@user
Feature: User edition

  @cleanup
  Scenario: Display an existing user on the page
	Given I have a stored user with:
	  | Firstname | Frederic |
	  | Lastname | Dewinne |
	When I go on page:
	  | /application/user/edit/ | %temporaryUser% |
	Then the "firstname" field should contain "Frederic"
	And the "lastname" field should contain "Dewinne"
