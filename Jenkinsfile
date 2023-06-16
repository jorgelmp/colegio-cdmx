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
          withKubeCredentials(kubectlCredentials: [[credentialsId: 'kube-credentials',serverUrl: 'https://192.168.124.254:6443']]) {
            sh 'curl -LO "https://storage.googleapis.com/kubernetes-release/release/v1.20.5/bin/linux/amd64/kubectl"'  
            sh 'chmod u+x ./kubectl'
            sh '''
                if ! ./kubectl get deployments | grep mysql
                then
                  ./kubectl apply -f mysql.yaml
                fi

                if ! ./kubectl get deployments | grep phpadmin
                then
                  ./kubectl apply -f phpadmin.yaml
                fi
                
                if ! ./kubectl get deployments | grep phpapp
                then
                  ./kubectl apply -f phpapp.yaml
                else
                  ./kubectl apply -f phpapp.yaml
                  ./kubectl rollout restart phpapp
                fi
            '''
          }
        }
      }
    }
  }
}