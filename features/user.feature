# tag will be herited
@user
Feature: User list feature

# space line is just here to be more readable
  Scenario: The user page should display a user list
	Given I am on "/application/user"
	Then the response status code should be 200
	And I should see "Firstname"
	And I should see "Lastname"

