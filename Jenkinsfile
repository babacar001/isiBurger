pipeline {
    agent any

    environment {
        GITHUB_REPO = 'https://github.com/babacar001/isiBurger.git'
        BRANCH_NAME = 'DIOP_Papa_Babacar_Mbissane_burger'
        DOCKER_IMAGE = 'isi_burger:latest'
        CONTAINER_NAME = 'isi_burger_container'
    }

    stages {
        stage('Cloner ou Mettre à jour le projet') {
            steps {
                script {
                    // Vérifier si la branche existe, sinon la créer
                    sh '''
                    git clone ${https://github.com/babacar001/isiBurger.git} || true
                    cd mon_projet
                    git checkout ${main} || git checkout -b ${DIOP_Papa_Babacar_Mbissane_burger}
                    git pull origin ${DIOP_Papa_Babacar_Mbissane_burger}
                    '''
                }
            }
        }

        stage('Installer les dépendances') {
            steps {
                sh '''
                cd isiBurger
                composer install --no-interaction --prefer-dist --optimize-autoloader
                cp .env.example .env
                php artisan key:generate
                '''
            }
        }

        stage('Créer une image Docker') {
            steps {
                sh '''
                cd isi_burger
                docker build -t ${isi_burger} .
                '''
            }
        }

        stage('Démarrer le conteneur') {
            steps {
                sh '''
                docker stop ${isi_burger_container} || true
                docker rm ${isi_burger_container} || true
                docker run -d --name ${isi_burger_container} -p 8000:80 ${isi_burger}
                '''
            }
        }
    }

    post {
        success {
            echo '✅ Déploiement réussi !'
        }
        failure {
            echo '❌ Une erreur s\'est produite'
        }
    }
}
// login mot de passe de jenkins admin 497fcbcbd3dc43febb396ada5651cbe1