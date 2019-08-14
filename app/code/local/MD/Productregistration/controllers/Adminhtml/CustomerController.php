<?php

class MD_Productregistration_Adminhtml_CustomerController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('productregistration/customer')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Product Registration'), Mage::helper('adminhtml')->__('Product Registration'));
		return $this;
	}   
	
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('productregistration/customer')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('productregistration_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('productregistration/customer');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Product Registration'), Mage::helper('adminhtml')->__('Product Registration'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('productregistration/adminhtml_customer_edit'))
				->_addLeft($this->getLayout()->createBlock('productregistration/adminhtml_customer_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productregistration')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
				
			$model = Mage::getModel('productregistration/customer');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				$model->save();
			switch ($model->getStatus()) {
				case 2:
					if(Mage::getStoreConfig('productregistration/general/enable_sent_mail')==1){
						$this->setMailAddMember($model);
					}				
					break;
				case 3:
					if(Mage::getStoreConfig('productregistration/general/enable_sent_mail')==1){
						$this->setMailAddMemberReject($model);
					}							
					break;
			}				
				
				// print_r($model->getStatus());
				// die('sent Mail ok');	
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productregistration')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productregistration')->__('Unable to find product registration to save'));
        $this->_redirect('*/*/');
	} 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('productregistration/customer');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $productregistrationIds = $this->getRequest()->getParam('productregistration');
        if(!is_array($productregistrationIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select product registration(s)'));
        } else {
            try {
                foreach ($productregistrationIds as $productregistrationId) {
                    $productregistration = Mage::getModel('productregistration/customer')->load($productregistrationId);
                    $productregistration->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($productregistrationIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $productregistrationIds = $this->getRequest()->getParam('productregistration');
        if(!is_array($productregistrationIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select productregistration(s)'));
        } else {
            try {
                foreach ($productregistrationIds as $productregistrationId) {
                    $productregistration = Mage::getSingleton('productregistration/customer')
                        ->load($productregistrationId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($productregistrationIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'productregistration.csv';
        $content    = $this->getLayout()->createBlock('productregistration/adminhtml_customer_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'productregistration.xml';
        $content    = $this->getLayout()->createBlock('productregistration/adminhtml_customer_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
    
    public function setMailAddMemberReject($procustomer)
	{	
		
		$emailData = array();
		$_storeName = Mage::app()->getStore()->getName();
		$emailData['to_email'] = $procustomer->getEmailcus();
		$emailData['to_name'] =  $procustomer->getNamecus();	
		$emailTemplate  = Mage::getModel('core/email_template')
						->loadDefault('product_notification_productregistration_reject');                                
		$emailTemplateVariables = array();
		$htlm="";
		if($procustomer->getModelnumber1()!=""){
			$htlm=$htlm.'<td class="fields"><tr><td style="padding-left: 20px;" >Equipment 1 :'.$procustomer->getEqipment1().'</td></tr><tr><td style="padding-left: 20px;" >Model Number: '.$procustomer->getModelnumber1().'</td></tr><tr><td style="padding-left: 20px;" >Serial Number: '.$procustomer->getSerial1().'</td></tr></td>';
		}

		if($procustomer->getModelnumber2()!=""){
			$htlm=$htlm.'<td class="fields"><tr><td style="padding-left: 20px;" >Equipment 2 :'.$procustomer->getEqipment2().'</td></tr><tr><td style="padding-left: 20px;" >Model Number: '.$procustomer->getModelnumber2().'</td></tr><tr><td style="padding-left: 20px;" >Serial Number: '.$procustomer->getSerial2().'</td></tr></td>';
		}

		if($procustomer->getModelnumber3()!=""){
			$htlm=$htlm.'<td class="fields"><tr><td style="padding-left: 20px;" >Equipment 3 :'.$procustomer->getEqipment3().'</td></tr><tr><td style="padding-left: 20px;" >Model Number: '.$procustomer->getModelnumber3().'</td></tr><tr><td style="padding-left: 20px;" >Serial Number: '.$procustomer->getSerial3().'</td></tr></td>';
		}
	
		
		// $emailTemplateVariables['logo_url'] = Mage::getDesign()->getSkinUrl(Mage::getStoreConfig('design/header/logo_src'));               
		$emailTemplateVariables['lable'] = 'Your product rejected register';               
		$emailTemplateVariables['data'] = $procustomer;               
		$emailTemplateVariables['html'] = $htlm;               
		$emailTemplateVariables['store'] = $_storeName;
		$emailTemplateVariables['websitename'] = Mage::app()->getWebsite()->getName(); 		
		$emailTemplateVariables['namecheckmail'] = $procustomer->getNamecus();              
		$emailTemplateVariables['baseurl'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);               
		$emailTemplateVariables['emailadmin'] = Mage::getStoreConfig('productregistration/general/admin_email');               
		$processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
		$emailTemplate->setSenderName(Mage::getStoreConfig('productregistration/general/admin_name'));
		$emailTemplate->setSenderEmail(Mage::getStoreConfig('productregistration/general/admin_email'));

		$emailTemplate->setTemplateSubject(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).' : Your product rejected register');
		$emailTemplate->send( $procustomer->getEmailcus(), $procustomer->getNamecus(), $emailTemplateVariables); 	
	}
   
    public function setMailAddMember($procustomer)
	{	
		
		$emailData = array();
		$_storeName = Mage::app()->getStore()->getName();
		$emailData['to_email'] = $procustomer->getEmailcus();
		$emailData['to_name'] =  $procustomer->getNamecus();	
		$emailTemplate  = Mage::getModel('core/email_template')
						->loadDefault('product_notification_productregistration_approve');                                
		$emailTemplateVariables = array();
		$htlm="";
		if($procustomer->getModelnumber1()!=""){
			$htlm=$htlm.'<td class="fields"><tr><td style="padding-left: 20px;" >Equipment 1 :'.$procustomer->getEqipment1().'</td></tr><tr><td style="padding-left: 20px;" >Model Number: '.$procustomer->getModelnumber1().'</td></tr><tr><td style="padding-left: 20px;" >Serial Number: '.$procustomer->getSerial1().'</td></tr></td>';
		}

		if($procustomer->getModelnumber2()!=""){
			$htlm=$htlm.'<td class="fields"><tr><td style="padding-left: 20px;" >Equipment 2 :'.$procustomer->getEqipment2().'</td></tr><tr><td style="padding-left: 20px;" >Model Number: '.$procustomer->getModelnumber2().'</td></tr><tr><td style="padding-left: 20px;" >Serial Number: '.$procustomer->getSerial2().'</td></tr></td>';
		}

		if($procustomer->getModelnumber3()!=""){
			$htlm=$htlm.'<td class="fields"><tr><td style="padding-left: 20px;" >Equipment 3 :'.$procustomer->getEqipment3().'</td></tr><tr><td style="padding-left: 20px;" >Model Number: '.$procustomer->getModelnumber3().'</td></tr><tr><td style="padding-left: 20px;" >Serial Number: '.$procustomer->getSerial3().'</td></tr></td>';
		}
	
		
		// $emailTemplateVariables['logo_url'] = Mage::getDesign()->getSkinUrl(Mage::getStoreConfig('design/header/logo_src'));               
		$emailTemplateVariables['lable'] = 'Your product successfully registered';               
		$emailTemplateVariables['data'] = $procustomer;               
		$emailTemplateVariables['html'] = $htlm;     
		$emailTemplateVariables['websitename'] = Mage::app()->getWebsite()->getName(); 
		$emailTemplateVariables['store'] = $_storeName;
		$emailTemplateVariables['namecheckmail'] = $procustomer->getNamecus();               	
		$emailTemplateVariables['baseurl'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB); 
		$emailTemplateVariables['emailadmin'] = Mage::getStoreConfig('productregistration/general/admin_email');
		$processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
		$emailTemplate->setSenderName(Mage::getStoreConfig('productregistration/general/admin_name'));
		$emailTemplate->setSenderEmail(Mage::getStoreConfig('productregistration/general/admin_email'));

		$emailTemplate->setTemplateSubject(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).' : Your product successfully registered');
		$emailTemplate->send( $procustomer->getEmailcus(), $procustomer->getNamecus(), $emailTemplateVariables); 	
	} 	
}