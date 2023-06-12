pipeline {

  }

  agent any

  stages {

    stage('Checkout Source') {
      steps {
        git branch: 'main', url: 'https://github.com/jorgelmp/colegio-cdmx'
      }
    }

    stage('Build image') {
      steps{
        script {
          sh 'docker build -t jorgelmp/colegio-cdmx .'
        }
      }
    }

    stage('Pushing Image') {
      steps{
        script {
          withCredentials([string(credentialsId: 'dockerhub-credentials', variable: 'dockerhubpwd')]) {
            sh 'docker login -u jorgelmp -p ${dockerhubpwd}'
            sh 'docker push jorgelmp/colegio-cdmx'
          }
        }
      }
    }

    stage('Deploying React.js container to Kubernetes') {
      steps {
        script {
          kubernetesDeploy(configs: "servidor-web-deploy.yaml", "servidor-web-service.yaml", kubeconfigId: 'kbconfig')
        }
      }
    }

  }

}