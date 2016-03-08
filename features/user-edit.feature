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

  Scenario Outline: Display an error on a non existing user page
	Given I am on "<url>"
	Then the response status code should be 404
	And I should see "The user has not been found"

	Examples:
	| url                          |
	| /application/user/edit/0     |
	| /application/user/edit/12345 |
