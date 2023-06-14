pipeline {
  
  environment {
    dockerimagename = "jorgelmp/colegio-cdmx"
    dockerImage = ""
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
          dockerImage = docker.build dockerimagename
        }
      }
    }

    stage('Pushing Image') {
      environment {
        registryCredential = 'dockerhublogin'
      }
      steps{
        script {
          docker.withRegistry( 'https://registry.hub.docker.com', registryCredential ) {
            dockerImage.push("latest")
          }
        }
      }
    }

    stage('Deploying container to Kubernetes') {
      steps{
        script {
          //kubernetesDeploy(configs: "servidor-web-deploy-svc.yaml", kubeconfigId: 'kbconfig')
          withKubeCredentials([credentialsId: 'kube-credentials',serverUrl:'https://192.168.124.254']) {
            sh '''
                if kubectl get deployments | grep servidor-web
                then
                  kubectl rollout restart deployment servidor-web
                else
                  kubectl apply -f servidor-web-deploy-svc.yaml
                fi
            '''
          }
        }
      }
    }
  }
}