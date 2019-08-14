<?php

class MD_Productregistration_Block_Adminhtml_Customer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('productregistrationGrid');
      $this->setDefaultSort('customer_id');
      $this->setDefaultDir('desc');
      $this->setSaveParametersInSession(false);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('productregistration/customer')->getCollection()->setOrder('customer_id','DESC');
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
     
      $this->addColumn('invoice', array(
          'header'    => Mage::helper('productregistration')->__('Invoice'),
          'align'     =>'center',
		  'width'     => '200px',
          'index'     => 'invoice',
      ));

	  $this->addColumn('namecus', array(
          'header'    => Mage::helper('productregistration')->__('Name'),
          'align'     =>'center',
		  'width'     => '250px',
          'index'     => 'namecus',
      ));
	  $this->addColumn('store_id', array(
          'header'    => Mage::helper('productregistration')->__('Name'),
          'align'     =>'center',
		  'width'     => '250px',
          'index'     => 'store_id',
      ));

	  $this->addColumn('emailcus', array(
          'header'    => Mage::helper('productregistration')->__('Email'),
          'align'     =>'center',
          'index'     => 'emailcus',
      ));

	  	  $this->addColumn('datecus', array(
          'header'    => Mage::helper('productregistration')->__('Date of install'),
          'align'     =>'center',
          'width'     => '40px',
          'index'     => 'datecus',
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('productregistration')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Pendding',
              2 => 'Approve',
              3 => 'Reject',
          ),
      ));
  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('productregistration')->__('Action'),
                'width'     => '100',
				'align'     =>'center',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('customer')->__('view'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('productregistration')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('productregistration')->__('XML'));
	  
      return parent::_prepareColumns();
  }

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('customer_id');
		$this->getMassactionBlock()->setFormFieldName('productregistration');

		$this->getMassactionBlock()->addItem('delete', array(
			 'label'    => Mage::helper('productregistration')->__('Delete'),
			 'url'      => $this->getUrl('*/*/massDelete'),
			 'confirm'  => Mage::helper('productregistration')->__('Are you sure?')
		));
		return $this;
	}
    // protected function _prepareMassaction()
    // {
        // $this->setMassactionIdField('customer_id');
        // $this->getMassactionBlock()->setFormFieldName('productregistration');

        // $this->getMassactionBlock()->addItem('delete', array(
             // 'label'    => Mage::helper('productregistration')->__('Delete'),
             // 'url'      => $this->getUrl('*/*/massDelete'),
             // 'confirm'  => Mage::helper('productregistration')->__('Are you sure?')
        // ));

        // $statuses = Mage::getSingleton('productregistration/status')->getOptionArray();

        // array_unshift($statuses, array('label'=>'', 'value'=>''));
        // $this->getMassactionBlock()->addItem('status', array(
             // 'label'=> Mage::helper('productregistration')->__('Change status'),
             // 'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             // 'additional' => array(
                    // 'visibility' => array(
                         // 'name' => 'status',
                         // 'type' => 'select',
                         // 'class' => 'required-entry',
                         // 'label' => Mage::helper('productregistration')->__('Status'),
                         // 'values' => $statuses
                     // )
             // )
        // ));
        // return $this;
    // }
  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}