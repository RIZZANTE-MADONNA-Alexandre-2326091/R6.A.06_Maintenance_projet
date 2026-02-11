Feature: Sport API
  In order to manage sports
  As an API client
  I need to be able to create, read, update and delete sports

  Scenario: List all sports
    When I send a GET request to "/api/sports"
    Then the response status code should be 200
    And the response should be in JSON

  Scenario: Create a new sport
    When I send a POST request to "/api/sports" with body:
      """
      {
        "name": "Football",
        "type": "equipe"
      }
      """
    Then the response status code should be 201
    And the response should be in JSON
    And the JSON node "name" should be equal to "Football"
    And the JSON node "type" should be equal to "equipe"

  Scenario: Get a specific sport
    Given I send a POST request to "/api/sports" with body:
      """
      {
        "name": "Basketball",
        "type": "equipe"
      }
      """
    And I store the JSON node "id" as "sportId"
    When I send a GET request to "/api/sports/{sportId}"
    Then the response status code should be 200
    And the JSON node "name" should be equal to "Basketball"

  Scenario: Update a sport
    Given I send a POST request to "/api/sports" with body:
      """
      {
        "name": "Tennis",
        "type": "individuel"
      }
      """
    And I store the JSON node "@id" as "sportIri"
    When I send a PUT request to "{sportIri}" with body:
      """
      {
        "name": "Tennis de Table",
        "type": "individuel"
      }
      """
    Then the response status code should be 200
    And the JSON node "name" should be equal to "Tennis de Table"

  Scenario: Partially update a sport
    Given I send a POST request to "/api/sports" with body:
      """
      {
        "name": "Volley",
        "type": "equipe"
      }
      """
    And I store the JSON node "@id" as "sportIri"
    When I send a PATCH request to "{sportIri}" with body:
      """
      {
        "name": "Volley-ball"
      }
      """
    Then the response status code should be 200
    And the JSON node "name" should be equal to "Volley-ball"
    And the JSON node "type" should be equal to "equipe"

  Scenario: Delete a sport
    Given I send a POST request to "/api/sports" with body:
      """
      {
        "name": "Rugby",
        "type": "equipe"
      }
      """
    And I store the JSON node "@id" as "sportIri"
    When I send a DELETE request to "{sportIri}"
    Then the response status code should be 204

  Scenario: Get a non-existent sport returns 404
    When I send a GET request to "/api/sports/99999"
    Then the response status code should be 404

  Scenario: Create a sport with invalid data returns 422
    When I send a POST request to "/api/sports" with body:
      """
      {
        "name": "",
        "type": "invalid"
      }
      """
    Then the response status code should be 422
