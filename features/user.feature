# tag will be herited
@user
Feature: User list feature
# space line is just here to be more readable
  Scenario: The user page should display a user list
	Given I am on "/application/user"
	Then the response status code should be 200
	And I should see "Firstname"
	And I should see "Lastname"

  Scenario: The user page should have an add user button
	Given I am on "/application/user"
	When I follow "Add user"
	Then I should be on "/application/user/add"
	And the response status code should be 200

  Scenario: The user list should have an edit button
	Given I am on "/application/user"
	And I have a stored user with:
	  | Firstname | Frederic |
	  | Lastname | Dewinne |
	When I follow "Edit user"
	Then the url should match "/application/user/\d+"
	And I should be on the user edit page
	And the response status code should be 200
