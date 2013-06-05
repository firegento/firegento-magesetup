<?php
/**
 * This file is part of the FIREGENTO project.
 *
 * FireGento_GermanSetup is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License version 3 as
 * published by the Free Software Foundation.
 *
 * This script is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * PHP version 5
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2012 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
/**
 * Block to display agreements on customer registration.
 *
 * @category  FireGento
 * @package   FireGento_GermanSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2013 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     1.2.2
 */

class FireGento_GermanSetup_Block_Customer_Account_Agreements extends Mage_Checkout_Block_Agreements
{

    /**
     * Filter by "Agreement Type"
     *
     * @return mixed
     */
    public function getAgreements()
    {
        $agreements = parent::getAgreements();
        $agreements->addFieldToFilter('agreement_type', array('in' => array(
            FireGento_GermanSetup_Model_Source_AgreementType::AGREEMENT_TYPE_CUSTOMER,
            FireGento_GermanSetup_Model_Source_AgreementType::AGREEMENT_TYPE_BOTH,
        )));
        return $agreements;
    }

}
