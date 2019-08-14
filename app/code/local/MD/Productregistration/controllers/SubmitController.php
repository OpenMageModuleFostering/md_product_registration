<?php
session_start();
class MD_Productregistration_SubmitController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {	
		
		$session = Mage::getSingleton('core/session', array('name'=>'frontend'));
		$data = $this->getRequest()->getPost();
		$capt = $this->getRequest()->getPost('captcharnumber');
		$_capt = $session->getCodeCaptcha();

		// die($_capt);
		if ($capt === $_capt)
		{	
			if (!empty($data)) {
			
            $procustomer = Mage::getModel('productregistration/customer')->setData($data);
            /* @var $review Mage_Review_Model_Review */
        	if ($procustomer->getCreatedTime == NULL || $procustomer->getUpdateTime() == NULL) {
				$procustomer->setCreatedTime(now())->setUpdateTime(now());
				
			} else {
				$procustomer->setUpdateTime(now());
			}
			
			try {
				
				if(Mage::getStoreConfig('productregistration/general/enable_sent_mail')==1){
					$this->setMailAddMember($procustomer);
					$this->setMailAdmin($procustomer);
				}				
				$procustomer->save();
				$session->setCheckData(1);
				$customer11 = Mage::getModel('productregistration/customer')->getCollection();
				$data['customer_id'] = $customer11->getLastItem()->getId();
				$proinstaller = Mage::getModel('productregistration/installer')->setData($data);
				$proproduct = Mage::getModel('productregistration/product')->setData($data);
				$proinstaller->setCreatedTime(now())->setUpdateTime(now());
				$proproduct->setCreatedTime(now())->setUpdateTime(now());
				$proinstaller->save();
				$proproduct->save();
				$session->addSuccess($this->__('Your information has been inserted.'));
			}
			catch (Exception $e) {
				$session->setCheckData(2);
				$session->setFormData($data);
				$session->addError($this->__('Unable to post your information. Please, try again later.'));
			}
            
		   }
		   $this->_redirect('productregistration');
		} else {
			$session->setFormData($data);
			$session->setCheckData(2);
			$session->addError($this->__('Please make sure captcha code match.'));
			$this->_redirect('productregistration');
		} 
    }
    public function setMailAddMember($procustomer)
	{	
		
		$emailData = array();
		$_storeName = Mage::app()->getStore()->getName();
		$emailData['to_email'] = $procustomer->getEmailcus();
		$emailData['to_name'] =  $procustomer->getNamecus();	
		$emailTemplate  = Mage::getModel('core/email_template')
						->loadDefault('product_notification_productregistration');                                
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
		$emailTemplateVariables['lable'] = 'You have already registered products';               
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

		$emailTemplate->setTemplateSubject(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).': You for submitting your product registration information');
		$emailTemplate->send( $procustomer->getEmailcus(), $procustomer->getNamecus(), $emailTemplateVariables); 	
	}	
    public function setMailAdmin($procustomer)
	{	
		
		$emailData = array();
		$_storeName = Mage::app()->getStore()->getName();
		$emailData['to_email'] = $procustomer->getEmailcus();
		$emailData['to_name'] =  $procustomer->getNamecus();	
		$emailTemplate  = Mage::getModel('core/email_template')
						->loadDefault('product_notification_productregistration_admin');                                
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
		$emailTemplateVariables['lable'] = 'You have already registered products';               
		$emailTemplateVariables['data'] = $procustomer;               
		$emailTemplateVariables['name'] = Mage::getStoreConfig('productregistration/general/admin_name');
		$emailTemplateVariables['html'] = $htlm;               
		$emailTemplateVariables['store'] = $_storeName; 
		$emailTemplateVariables['websitename'] = Mage::app()->getWebsite()->getName(); 
		$emailTemplateVariables['namecheckmail'] = Mage::getStoreConfig('productregistration/general/admin_name');
		$emailTemplateVariables['baseurl'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);               
		$emailTemplateVariables['emailadmin'] = Mage::getStoreConfig('productregistration/general/admin_email');               
		$processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

		$emailTemplate->setSenderName($procustomer->getNamecus());
		$emailTemplate->setSenderEmail($procustomer->getEmailcus());

		$emailTemplate->setTemplateSubject(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).': Product information register customers');
		$emailTemplate->send( Mage::getStoreConfig('productregistration/general/admin_email'), Mage::getStoreConfig('productregistration/general/admin_name'), $emailTemplateVariables); 	
	}	
}
