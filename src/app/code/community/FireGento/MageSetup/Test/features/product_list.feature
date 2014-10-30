Feature: Product List
  As a website visitor
  I want to see products in a category
  So that I can see which products are offered and which tax rate they have

  Scenario: Tax Rate without shipping cost link
    Given I set config value for "catalog/price/cms_page_shipping" to "" in "default" scope
    And the cache is clean
    When I am on "/furniture.html"
    Then I should not see text "Inkl. 19% USt., zzgl. Versandkosten"
    Then I should see text "Inkl. 19% USt."

  Scenario: Tax Rate with not included shipping cost link
    Given I set config value for "catalog/price/cms_page_shipping" to "lieferung" in "default" scope
    And I set config value for "catalog/price/including_shipping_costs" to "0" in "default" scope
    And the cache is clean
    When I am on "/furniture.html"
    Then I should see text "Inkl. 19% USt., zzgl. Versandkosten"

  Scenario: Tax Rate with included shipping cost link
    Given I set config value for "catalog/price/cms_page_shipping" to "lieferung" in "default" scope
    And I set config value for "catalog/price/including_shipping_costs" to "1" in "default" scope
    And the cache is clean
    When I am on "/furniture.html"
    Then I should see text "Inkl. 19% USt., inkl. Versandkosten"
