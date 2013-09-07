<?php

class FireGento_MageSetup_Test_Model_Source_AgreementType extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var FireGento_MageSetup_Model_Source_AgreementType
     */
    protected $_model;

    /**
     * Sets up the helper class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_model = Mage::getModel('magesetup/source_agreementType');
    }

    /**
     * Test the toOptionArray method
     */
    public function testToOptionArray()
    {
        $actual = $this->_model->toOptionArray();
        $expected = $this->expected('result')->getData();

        $this->assertEquals(
            $expected,
            $actual
        );
    }

    /**
     * Test the getOptionArray method
     */
    public function testGetOptionArray()
    {
        $actual = $this->_model->getOptionArray();
        $expected = $this->expected('result')->getData();

        $this->assertEquals(
            $expected,
            $actual
        );
    }
}
