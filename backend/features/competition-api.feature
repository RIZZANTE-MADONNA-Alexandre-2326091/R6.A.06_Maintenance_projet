Feature: Competition API
  In order to manage competitions
  As an API client
  I need to be able to create, read, update and delete competitions

  Scenario: List all competitions
    When I send a GET request to "/api/competitions"
    Then the response status code should be 200
    And the response should be in JSON

  Scenario: Create a new competition
    When I send a POST request to "/api/competitions" with body:
      """
      {
        "name": "Compétition Nationale"
      }
      """
    Then the response status code should be 201
    And the response should be in JSON
    And the JSON node "name" should be equal to "Compétition Nationale"

  Scenario: Get a specific competition
    Given I send a POST request to "/api/competitions" with body:
      """
      {
        "name": "Compétition Départementale"
      }
      """
    And I store the JSON node "id" as "competitionId"
    When I send a GET request to "/api/competitions/{competitionId}"
    Then the response status code should be 200
    And the JSON node "name" should be equal to "Compétition Départementale"

  Scenario: Update a competition
    Given I send a POST request to "/api/competitions" with body:
      """
      {
        "name": "Compétition Junior"
      }
      """
    And I store the JSON node "@id" as "competitionIri"
    When I send a PUT request to "{competitionIri}" with body:
      """
      {
        "name": "Compétition Senior"
      }
      """
    Then the response status code should be 200
    And the JSON node "name" should be equal to "Compétition Senior"

  Scenario: Delete a competition
    Given I send a POST request to "/api/competitions" with body:
      """
      {
        "name": "Compétition à supprimer"
      }
      """
    And I store the JSON node "@id" as "competitionIri"
    When I send a DELETE request to "{competitionIri}"
    Then the response status code should be 204

  Scenario: Get a non-existent competition returns 404
    When I send a GET request to "/api/competitions/99999"
    Then the response status code should be 404

  Scenario: Create a competition with empty name returns 422
    When I send a POST request to "/api/competitions" with body:
      """
      {
        "name": ""
      }
      """
    Then the response status code should be 422
