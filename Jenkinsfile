pipeline {
  agent any

  stages {
    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('Deploy (Docker Compose)') {
      steps {
        sh '''
          docker compose down || true
          docker compose up -d --build
        '''
      }
    }

    stage('Smoke Test') {
      steps {
        sh '''
          echo "Testing endpoint..."
          curl -sSf http://localhost:8081/ > /dev/null
          echo "OK"
        '''
      }
    }
  }

  post {
    always {
      sh 'docker ps'
    }
  }
}
