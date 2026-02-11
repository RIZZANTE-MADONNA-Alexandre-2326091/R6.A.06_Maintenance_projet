Feature: Greet command
  In order to greet users
  As a CLI user
  I need to be able to run the greet command

  Scenario: Greeting a user by name
    When I run the command "app:greet Alice"
    Then the command should succeed
    And the output should contain "Hello Alice!"

  Scenario: Greeting with yell option
    When I run the command "app:greet Bob --yell"
    Then the command should succeed
    And the output should contain "HELLO BOB!"
