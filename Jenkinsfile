pipeline {
    agent any

    stages {
        stage('Build et test front + back') {
            steps {
                script {
                    try {
                        sh 'docker compose -f docker-compose.e2e.yml up -d --build'
                        sh 'docker compose -f docker-compose.e2e.yml exec -T backend_e2e touch .env'
                        sh 'docker compose -f docker-compose.e2e.yml exec -T backend_e2e composer install --no-interaction --prefer-dist'
                        sh 'docker compose -f docker-compose.e2e.yml exec -T backend_e2e bin/console doctrine:schema:update --force'
                        sh 'docker compose -f docker-compose.e2e.yml exec -T -d backend_e2e php -S 0.0.0.0:8000 -t public'
                        sh 'sleep 5'

                        catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                            dir('backend') {
                                sh 'docker compose -f ../docker-compose.e2e.yml exec -T backend_e2e vendor/bin/phpunit tests --log-junit test-report.xml --coverage-clover coverage-report.xml'
                            }
                        }
                        
                        dir('backend') {
                            sh 'docker cp $(docker compose -f ../docker-compose.e2e.yml ps -q backend_e2e):/app/test-report.xml . || true'
                            sh 'docker cp $(docker compose -f ../docker-compose.e2e.yml ps -q backend_e2e):/app/coverage-report.xml . || true'
                        }

                        catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                            sh 'docker compose -f docker-compose.e2e.yml run --rm --entrypoint "" cypress sh -c "npm install && cypress run"'
                        }
                        
                    } finally {
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
