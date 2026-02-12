Feature: Epreuve API
  In order to manage events
  As an API client
  I need to be able to create, read, update and delete events

  Scenario: List all events
    When I send a GET request to "/api/epreuves"
    Then the response status code should be 200
    And the response should be in JSON

  Scenario: Create a new event
    When I send a POST request to "/api/epreuves" with body:
      """
      {
        "name": "100m Haies"
      }
      """
    Then the response status code should be 201
    And the response should be in JSON
    And the JSON node "name" should be equal to "100m Haies"

  Scenario: Get a specific event
    Given I send a POST request to "/api/epreuves" with body:
      """
      {
        "name": "Saut en longueur"
      }
      """
    And I store the JSON node "id" as "epreuveId"
    When I send a GET request to "/api/epreuves/{epreuveId}"
    Then the response status code should be 200
    And the JSON node "name" should be equal to "Saut en longueur"

  Scenario: Update an event
    Given I send a POST request to "/api/epreuves" with body:
      """
      {
        "name": "Saut en hauteur"
      }
      """
    And I store the JSON node "@id" as "epreuveIri"
    When I send a PUT request to "{epreuveIri}" with body:
      """
      {
        "name": "Triple saut"
      }
      """
    Then the response status code should be 200
    And the JSON node "name" should be equal to "Triple saut"

  Scenario: Delete an event
    Given I send a POST request to "/api/epreuves" with body:
      """
      {
        "name": "Épreuve à supprimer"
      }
      """
    And I store the JSON node "@id" as "epreuveIri"
    When I send a DELETE request to "{epreuveIri}"
    Then the response status code should be 204

  Scenario: Get a non-existent event returns 404
    When I send a GET request to "/api/epreuves/99999"
    Then the response status code should be 404

  Scenario: Create an event with empty name returns 422
    When I send a POST request to "/api/epreuves" with body:
      """
      {
        "name": ""
      }
      """
    Then the response status code should be 422

  Scenario: Verify fixture events are present
    When I send a GET request to "/api/epreuves"
    Then the response status code should be 200
    And the response should be in JSON
    And the JSON should contain at least 13 items in "hydra:member"

  Scenario: Verify Football events exist in fixtures
    When I send a GET request to "/api/epreuves"
    Then the response status code should be 200
    And the JSON array "hydra:member" should contain an item with "name" containing "Football"

  Scenario: Verify Athletics events exist in fixtures
    When I send a GET request to "/api/epreuves"
    Then the response status code should be 200
    And the JSON array "hydra:member" should contain an item with "name" equal to "100m Sprint"

  Scenario: Verify Swimming events exist in fixtures
    When I send a GET request to "/api/epreuves"
    Then the response status code should be 200
    And the JSON array "hydra:member" should contain an item with "name" equal to "50m Nage Libre"

  Scenario: Verify Basketball events exist in fixtures
    When I send a GET request to "/api/epreuves"
    Then the response status code should be 200
    And the JSON array "hydra:member" should contain an item with "name" containing "Basketball"

  Scenario: Verify Judo events exist in fixtures
    When I send a GET request to "/api/epreuves"
    Then the response status code should be 200
    And the JSON array "hydra:member" should contain an item with "name" containing "Judo"

  Scenario: Verify events have sports associations
    When I send a GET request to "/api/epreuves"
    Then the response status code should be 200
    And at least one event should have a sport associated
