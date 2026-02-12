Feature: Championnat API
  In order to manage championships
  As an API client
  I need to be able to create, read, update and delete championships

  Scenario: List all championships
    When I send a GET request to "/api/championnats"
    Then the response status code should be 200
    And the response should be in JSON

  Scenario: Create a new championship
    When I send a POST request to "/api/championnats" with body:
      """
      {
        "name": "Championnat de France"
      }
      """
    Then the response status code should be 201
    And the response should be in JSON
    And the JSON node "name" should be equal to "Championnat de France"

  Scenario: Get a specific championship
    Given I send a POST request to "/api/championnats" with body:
      """
      {
        "name": "Championnat National"
      }
      """
    And I store the JSON node "id" as "championnatId"
    When I send a GET request to "/api/championnats/{championnatId}"
    Then the response status code should be 200
    And the JSON node "name" should be equal to "Championnat National"

  Scenario: Update a championship
    Given I send a POST request to "/api/championnats" with body:
      """
      {
        "name": "Championnat Junior"
      }
      """
    And I store the JSON node "@id" as "championnatIri"
    When I send a PUT request to "{championnatIri}" with body:
      """
      {
        "name": "Championnat Senior"
      }
      """
    Then the response status code should be 200
    And the JSON node "name" should be equal to "Championnat Senior"

  Scenario: Delete a championship
    Given I send a POST request to "/api/championnats" with body:
      """
      {
        "name": "Championnat à supprimer"
      }
      """
    And I store the JSON node "@id" as "championnatIri"
    When I send a DELETE request to "{championnatIri}"
    Then the response status code should be 204

  Scenario: Get a non-existent championship returns 404
    When I send a GET request to "/api/championnats/99999"
    Then the response status code should be 404

  Scenario: Create a championship with empty name returns 422
    When I send a POST request to "/api/championnats" with body:
      """
      {
        "name": ""
      }
      """
    Then the response status code should be 422

  Scenario: Verify fixture championships are present
    When I send a GET request to "/api/championnats"
    Then the response status code should be 200
    And the response should be in JSON
    And the JSON should contain at least 3 items in "hydra:member"

  Scenario: Verify UGSEL Bretagne championship exists
    When I send a GET request to "/api/championnats"
    Then the response status code should be 200
    And the JSON array "hydra:member" should contain an item with "name" equal to "UGSEL Bretagne 2025-2026"

  Scenario: Verify UGSEL National championship exists
    When I send a GET request to "/api/championnats"
    Then the response status code should be 200
    And the JSON array "hydra:member" should contain an item with "name" equal to "UGSEL National 2025-2026"

  Scenario: Verify championships have competitions
    When I send a GET request to "/api/championnats"
    Then the response status code should be 200
    And at least one championship should have competitions associated
