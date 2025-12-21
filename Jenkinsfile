pipeline {
    agent any  // يحدد أن الجوب سيتم تنفيذه على أي agent متاح

    stages {
        // مرحلة جلب الشيفرة من المستودع
        stage('Checkout') {
            steps {
                checkout scm  // جلب الشيفرة المصدرية من مستودع Git
            }
        }

        // مرحلة نشر التطبيق باستخدام Docker Compose
        stage('Deploy (Docker Compose)') {
            steps {
                sh '''
                  docker compose down || true  // إيقاف الخدمات القديمة
                  docker compose up -d --build  // بناء وإطلاق الحاويات من جديد
                '''
            }
        }

        // مرحلة اختبار بسيط للتأكد من أن التطبيق يعمل بشكل صحيح
        stage('Smoke Test') {
            steps {
                sh '''
                  echo "Testing endpoint..."
                  curl -sSf http://localhost:8081/ > /dev/null  // اختبار endpoint على http://localhost:8081
                  echo "OK"  // إذا تم الاستجابة بنجاح
                '''
            }
        }
    }

    // مرحلة ما بعد التنفيذ: يتم تشغيل هذا القسم دائمًا بعد اكتمال الجوب
    post {
        always {
            sh 'docker ps'  // يعرض الحاويات الجارية بعد تنفيذ الجوب
        }
    }
}
