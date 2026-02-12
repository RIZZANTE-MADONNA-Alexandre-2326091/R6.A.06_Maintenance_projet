pipeline {
    agent any

    stages {
        stage('Build et Test front + back') {
            steps {
                script {
                    try {
                        sh 'docker compose -f docker-compose.e2e.yml up -d --build'

                        sh 'docker compose -f docker-compose.e2e.yml exec -T backend_e2e composer install --no-interaction --prefer-dist'

                        // PHPUnit
                        dir('backend') {
                             sh 'docker compose -f ../docker-compose.e2e.yml exec -T backend_e2e vendor/bin/phpunit tests --log-junit test-report.xml --coverage-clover coverage-report.xml'
                        }

                        // Cypress 
                        sh 'docker compose -f docker-compose.e2e.yml up cypress --exit-code-from cypress'

                    } finally {
                        // Nettoyage 
                        sh 'docker compose -f docker-compose.e2e.yml down -v'
                    }
                }
            }
        }

        stage('Analyse SonarQube') {
            steps {
                dir('backend') {
                    withSonarQubeEnv('SonarQube') {
                        sh "${tool 'SonarScanner'}/bin/sonar-scanner"
                    }
                }
            }
        }
    }
}