<?php

class MD_Productregistration_Block_Adminhtml_Customer_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array('id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post'));
      $this->setForm($form);
      $fieldset = $form->addFieldset('productregistration_form', array('legend'=>Mage::helper('productregistration')->__('Customer Information')));
	  
      $fieldset->addField('invoice', 'text', array(
          'label'     => Mage::helper('productregistration')->__('Invoice'),
          'name'      => 'invoice',
		  'readonly' => true,
      ));

	  $fieldset->addField('namecus', 'text', array(
          'label'     => Mage::helper('productregistration')->__('Full Name'),
          'name'      => 'namecus',
		  'readonly' => true,
      ));
	
	  $fieldset->addField('emailcus', 'text', array(
          'label'     => Mage::helper('productregistration')->__('Email Address'),
          'name'      => 'emailcus',
		  'readonly' => true,
      ));	 
	  
	  $fieldset->addField('comment', 'textarea', array(
          'label'     => Mage::helper('productregistration')->__('Comment'),
          'name'      => 'comment',
      ));
		$fieldset->addField('status', 'select', array(
						'label'     => Mage::helper('productregistration')->__('Status'),
						'name'      => 'status',
						'value'		=> '1',   
						'values'    => array(
							array('value'=>'1','label'=>'Pendding'),
							array('value'=>'2','label'=>'Approve'),
							array('value'=>'3','label'=>'Reject')
						), 
					   'onchange' => 'checkform_pa(this.value)', 				
		));	  
	  $fieldset->addField('datecus', 'text', array(
          'label'     => Mage::helper('productregistration')->__('Date of install'),
          'name'      => 'datecus',
		  'readonly' => true,
      ));
	 $inss = Mage::getModel('productregistration/installer');
	 $inss = $inss->getCollection();
	 $inss->addFieldToFilter('customer_id',Array('eq'=>$this->getRequest()->getParam('id')));
	 foreach ($inss as $ins)
	 {
		 $fieldset = $form->addFieldset('productregistration_form1', array('legend'=>Mage::helper('productregistration')->__('Installer Information')));

		 $fieldset->addField('nameins', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Full Name'),
			  'name'      => 'nameins',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("nameins").value="'.$ins->getNameins().'";</script>',
		  ));
		  
		  $fieldset->addField('addressins', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Address'),
			  'name'      => 'addressins',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("addressins").value="'.$ins->getAddressins().'";</script>',
		  ));
		  
		  $fieldset->addField('city', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('City'),
			  'name'      => 'city',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("city").value="'.$ins->getCity().'";</script>',
		  ));
		  
		  $fieldset->addField('state', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('State'),
			  'name'      => 'state',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("state").value="'.$ins->getState().'";</script>',
		  ));
		  
		  $fieldset->addField('zip', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Zip Code'),
			  'name'      => 'zip',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("zip").value="'.$ins->getZip().'";</script>',
		  ));
		  
		  $fieldset->addField('emailadd', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Email Address'),
			  'name'      => 'emailadd',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("emailadd").value="'.$ins->getEmailadd().'";</script>',
		  ));
		  
		  $fieldset->addField('phone', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Phone'),
			  'name'      => 'phone',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("phone").value="'.$ins->getPhone().'";</script>',
		  ));
		  if ($ins->getRecommend())
			  $rec = "yes";
		  else
			  $rec = "no";
		   $fieldset->addField('recommend', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Recommend'),
			  'name'      => 'recommend',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("recommend").value="'.$rec.'";</script>',
		  ));
		  
	  }
	  
     $pros = Mage::getModel('productregistration/product');
	 $pros = $pros->getCollection();
	 $pros->addFieldToFilter('customer_id',Array('eq'=>$this->getRequest()->getParam('id')));
	 foreach ($pros as $pro)
	 {
		 $fieldset = $form->addFieldset('productregistration_form2', array('legend'=>Mage::helper('productregistration')->__('Product Information')));

		 $fieldset->addField('eqipment1', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Eqipment 1'),
			  'name'      => 'eqipment1',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("eqipment1").value="'.$pro->getEqipment1().'";</script>',
		  ));
		  
		  $fieldset->addField('modelnumber1', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Model Number'),
			  'name'      => 'modelnumber1',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("modelnumber1").value="'.$pro->getModelnumber1().'";</script>',
		  ));
		  
		  $fieldset->addField('serial1', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Serial Number'),
			  'name'      => 'serial1',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("serial1").value="'.$pro->getSerial1().'";</script>',
		  ));
		  
		 $fieldset->addField('eqipment2', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Eqipment 2'),
			  'name'      => 'eqipment2',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("eqipment2").value="'.$pro->getEqipment2().'";</script>',
		  ));
		  
		  $fieldset->addField('modelnumber2', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Model Number'),
			  'name'      => 'modelnumber2',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("modelnumber2").value="'.$pro->getModelnumber2().'";</script>',
		  ));
		  
		  $fieldset->addField('serial2', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Serial Number'),
			  'name'      => 'serial2',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("serial2").value="'.$pro->getSerial2().'";</script>',
		  ));
		  
		  $fieldset->addField('eqipment3', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Eqipment 3'),
			  'name'      => 'eqipment3',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("eqipment3").value="'.$pro->getEqipment3().'";</script>',
		  ));
		  
		  $fieldset->addField('modelnumber3', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Model Number'),
			  'name'      => 'modelnumber3',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("modelnumber3").value="'.$pro->getModelnumber3().'";</script>',
		  ));
		  
		  $fieldset->addField('serial3', 'text', array(
			  'label'     => Mage::helper('productregistration')->__('Serial Number'),
			  'name'      => 'serial3',
			  'readonly' => true,
			  'after_element_html' => '<script type="text/javascript">document.getElementById("serial3").value="'.$pro->getSerial3().'";</script>',
		  ));
		  
	  }
      if ( Mage::getSingleton('adminhtml/session')->getProductregistrationData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getProductregistration());
          Mage::getSingleton('adminhtml/session')->setProductregistration(null);
      } elseif ( Mage::registry('productregistration_data') ) {
          $form->setValues(Mage::registry('productregistration_data')->getData());
      }
      return parent::_prepareForm();
  }
}
?>
<script>
	function checkform_pa(value)
	{
		if(value=="2" || value=="1"){	
		document.getElementById("comment").setAttribute("class", "required-entry");
		}else{
		document.getElementById("comment").setAttribute("class", "");
		}
	}
</script>