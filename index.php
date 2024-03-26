<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Çöz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            padding: 10px;
            border-radius: 5px;
        }
        li:hover {
            background-color: #f9f9f9;
        }
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 10px;
            box-sizing: border-box;
        }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Çöz</h1>
        <?php
        // Load questions and fake answers from JSON file
        $data = json_decode(file_get_contents('FakeAnswers.json'), true);

        // Pick a random question
        $randomQuestion = $data[array_rand($data)];

        // Display the question
        echo "<h2>{$randomQuestion['question']}</h2>";

        // Initialize an array to store all answers except the correct one
        $otherAnswers = [];

        // Add correct answer to the options
        $options = ["A", "B", "C", "D"];
        $correctAnswerIndex = array_rand($options);
        $correctAnswer = $randomQuestion['answers'][0]; // Assuming only one correct answer
        $options[$correctAnswerIndex] = "$options[$correctAnswerIndex] - $correctAnswer";

        // Remove correct answer from other answers
        unset($randomQuestion['answers'][0]);

        // Add other answers to the otherAnswers array
        foreach ($randomQuestion['answers'] as $answer) {
            $otherAnswers[] = $answer;
        }

        // Shuffle other answers
        shuffle($otherAnswers);

        // Add other answers to options
        $index = 0;
        foreach ($options as $option) {
            if (strpos($option, "-") !== false) {
                // If it's the correct answer, just display it
                $optionText = $option;
            } else {
                // If it's not the correct answer, add the fake answer text
                $optionText = $option . " - " . $otherAnswers[$index];
                $index++;
            }
            echo "<li onclick='checkClosedAnswer(\"$option\", \"$correctAnswer\")'>$optionText</li>";
        }
        ?>
    </div>

    <!-- Include sweetAlert script -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function checkClosedAnswer(selectedAnswer, correctAnswer) {
            if (selectedAnswer.includes(" - ")) {
                selectedAnswer = selectedAnswer.split(" - ")[1]; // Extract the answer part
            }
            if (selectedAnswer === correctAnswer) {
                // Correct answer
                swal("Doğru!", "Tebrikler, doğru cevap!", "success").then(() => {
                    // Reload the page to load another question
                    window.location.reload();
                });
            } else {
                // Wrong answer
                swal("Yanlış!", "Tekrar deneyin!", "error");
            }
        }
    </script>
</body>
</html>
