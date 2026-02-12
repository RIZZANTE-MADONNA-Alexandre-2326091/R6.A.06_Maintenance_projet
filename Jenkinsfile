pipeline {
    agent any

    stages {
        stage('Build et test backend + frontend') {
            steps {
                script {
                    try {
                        sh 'docker compose -f docker-compose.e2e.yml up -d --build --wait'

                        dir('backend') {
                             sh 'docker compose -f ../docker-compose.e2e.yml exec -T backend_e2e vendor/bin/phpunit tests --log-junit test-report.xml --coverage-clover coverage-report.xml'
                        }

                        sh 'docker compose -f docker-compose.e2e.yml up cypress --exit-code-from cypress'

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
                        sh "/var/jenkins_home/tools/hudson.plugins.sonar.SonarRunnerInstallation/SonarScanner/bin/sonar-scanner"
                    }
                }
            }
        }
    }
}
