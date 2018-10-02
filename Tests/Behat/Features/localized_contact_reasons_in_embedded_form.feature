@ticket-BAP-13174
@automatically-ticket-tagged
@fixture-OroLocaleBundle:LocalizationFixture.yml
Feature: Localized contact reasons in embedded form
  In order to create embedded forms with localized contact reasons
  As an admin
  I need to be able to create new embedded form and submit it with contact reason option selected

  Scenario: Add localization for contact reason
    Given I login as administrator
    And I enable the existing localizations
    And I go to System/Configuration
    And follow "System Configuration/General Setup/Localization" on configuration sidebar
    When fill form with:
      |Default Localization |Localization1|
    And submit form
    Then I should see "Configuration saved" flash message
    And go to System/ Contact Reasons
    When I should see Want to know more about the product in grid with following data:
      | Label | Want to know more about the product |
    And I click edit "Want to know more about the product" in grid
    And I click on "Contact Reason Form Label Fallbacks"
    And fill "Contact Reason Form" with:
      | Label Second Use Default | false                                                |
      | Label Second             | Want to know more about the product (Localization 1) |
    And I save and close form
    Then I should see "Contact reason has been saved successfully" flash message

  Scenario: Create new embedded form
    Given I go to System/Integrations/Embedded Forms
    And click "Create Embedded Form"
    When I fill "Embedded Form" with:
      | Title           | Magento contact us form              |
      | Form Type       | Magento Contact Us Request           |
      | CSS             | #testId { position: absolute; }      |
      | Success Message | Form has been submitted successfully |
    And I save and close form
    Then I should see "Form has been saved successfully" flash message

  Scenario: Submit Magento contact us form with localized contact reason selected
    Given I fill "Magento contact us form with contact reasons" with:
      | First name               | John                 |
      | Last name                | Doe                  |
      | Preferred contact method | Email                |
      | Email                    | john-doe@example.com |
      | Comment                  | New comment          |
      | Contact reason           | Want to know more about the product (Localization 1) |
    When I press "Submit" in "Magento contact us form with contact reasons"
    Then I should see "Form has been submitted successfully"
    And I go to Activities/ Contact Requests
    And I should see John in grid with following data:
      | LAST NAME | Doe                  |
      | EMAIL     | john-doe@example.com |
