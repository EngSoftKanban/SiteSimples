<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentários</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #b8cfac;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .comment-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        textarea {
            width: 96%;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #b8cfac;
            resize: none;
        }

        button {
            width: 20%;
            margin: 0 auto;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold; 
        }

        button:hover {
            background-color: #218838;
        }

        .comment-list {
            margin-top: 20px;
        }

        .comment {
            background-color: #ebf3e7;
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 15px;
        }

        .nickname {
            font-weight: bold;
            color: #555;
        }

        .comment-text {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Deixe seu comentário</h1>
        
        <!-- Formulário para envio de comentários -->
        <form action="" method="post" class="comment-form">
            <textarea name="nickname" placeholder="Apelido" required></textarea>
            <textarea name="comment" placeholder="Escreva seu comentário..." required></textarea>
            <button type="submit">Enviar</button>
        </form>

        <div class="comment-list">
            <?php
            // Salva o comentário no arquivo se o formulário foi submetido
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nickname = trim(htmlspecialchars($_POST['nickname']));
                $comment = trim(htmlspecialchars($_POST['comment']));

                if (!empty($nickname) && !empty($comment)) {
                    $commentEntry = $nickname . '|' . $comment . "\n";
                    file_put_contents('comments.txt', $commentEntry, FILE_APPEND | LOCK_EX);

                    // Evita reenvio do formulário ao recarregar a página
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }
            }

            // verifica se o arquivo comments.txt existe
            if (file_exists('comments.txt')) {
                $comments = file('comments.txt');
                foreach ($comments as $comment) {
                    list($nickname, $commentText) = explode('|', $comment);

                    // remove possiveis espaços em branco
                    $nickname = trim($nickname);
                    $commentText = trim($commentText);

                    //mostra o comentário na pagina
                    echo "<div class='comment'><p class='nickname'>" . htmlspecialchars($nickname) . "</p><p class='comment-text'>" . htmlspecialchars($commentText) . "</p></div>";
                }
            } else {
                echo "Arquivo de comentários não encontrado.";
            }
            ?>
        </div>
    </div>
</body>
</html>
