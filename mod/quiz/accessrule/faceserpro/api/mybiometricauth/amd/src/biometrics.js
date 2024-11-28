define(['jquery', 'core/notification'], function($, notification) {

    const API_URL = M.cfg.wwwroot + '/mod/quiz/accessrule/mybiometricauth/api_handler.php';

    return {
        init: function() {
            let videoElement = document.querySelector('#webcam');
            let canvasElement = document.querySelector('#captureCanvas');
            let context = canvasElement.getContext('2d');
            let startButton = document.querySelector('#startCapture');
            let validateButton = document.querySelector('#validateCapture');
            let retryButton = document.querySelector('#retryCapture');

            // Start webcam feed
            startButton.addEventListener('click', function() {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function(stream) {
                        videoElement.srcObject = stream;
                        videoElement.play();
                    })
                    .catch(function(err) {
                        notification.alert('Error', 'Failed to access the webcam: ' + err.message, 'error');
                    });
            });

            // Capture image from webcam
            validateButton.addEventListener('click', function() {
                context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
                let imageData = canvasElement.toDataURL('image/png');

                // Send captured image to API for validation
                validateBiometric(imageData);
            });

            // Retry button to reset interface
            retryButton.addEventListener('click', function() {
                context.clearRect(0, 0, canvasElement.width, canvasElement.height);
                videoElement.srcObject.getTracks().forEach(track => track.stop());
                videoElement.srcObject = null;
            });

            // Function to validate biometrics via API
            function validateBiometric(imageData) {
                $.ajax({
                    url: API_URL,
                    type: 'POST',
                    data: {
                        action: 'validate_biometric',
                        image: imageData
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            notification.alert('Success', 'Biometric validation passed! You can now access the quiz.', 'success');
                            window.location.reload(); // Proceed to quiz
                        } else {
                            notification.alert('Error', response.message || 'Biometric validation failed. Please try again.', 'error');
                        }
                    },
                    error: function(err) {
                        notification.alert('Error', 'An error occurred during validation. Please try again later.', 'error');
                    }
                });
            }
        }
    };
});
