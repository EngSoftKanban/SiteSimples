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
        }

        .container {
            width: 50%;
            margin: 0 auto;
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
        <form id="commentForm" action="" method="post" class="comment-form">
            <textarea name="nickname" placeholder="Apelido" required></textarea>
            <textarea name="comment" placeholder="Escreva seu comentário..." required></textarea>
            <button type="submit">Enviar</button>
        </form>

        <div class="comment-list" id="commentList">
            <!-- Comentários serão inseridos aqui -->
            <?php
            // Salva o comentário no arquivo se o formulário foi submetido
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nickname = htmlspecialchars($_POST['nickname']);
                $comment = htmlspecialchars($_POST['comment']);

                $commentEntry = $nickname . '|' . $comment . "\n";

                file_put_contents('comments.txt', $commentEntry, FILE_APPEND | LOCK_EX);

                // Evita reenvio do formulário ao recarregar a página
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            }

            // Lê os comentários de um arquivo de texto
            if(file_exists('comments.txt')){
                $comments = file('comments.txt');
                foreach ($comments as $comment) {
                    list($nickname, $commentText) = explode('|', $comment);
                    echo "<div class='comment'><p class='nickname'>$nickname</p><p class='comment-text'>$commentText</p></div>";
                }
            }
            ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentForm = document.getElementById('commentForm');
            const commentList = document.getElementById('commentList');

            commentForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(commentForm);
                const nickname = formData.get('nickname');
                const commentText = formData.get('comment');

                fetch(commentForm.action, {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    if (response.ok) {
                        // Adiciona o novo comentário na interface imediatamente
                        const commentDiv = document.createElement('div');
                        commentDiv.className = 'comment';
                        const nicknameP = document.createElement('p');
                        nicknameP.className = 'nickname';
                        nicknameP.textContent = nickname;
                        const commentTextP = document.createElement('p');
                        commentTextP.className = 'comment-text';
                        commentTextP.textContent = commentText;
                        commentDiv.appendChild(nicknameP);
                        commentDiv.appendChild(commentTextP);
                        commentList.insertBefore(commentDiv, commentList.firstChild);

                        commentForm.reset();
                    }
                });
            });

            function loadComments() {
                fetch('get_comments.php')
                    .then(response => response.json())
                    .then(comments => {
                        commentList.innerHTML = '';
                        comments.forEach(comment => {
                            const commentDiv = document.createElement('div');
                            commentDiv.className = 'comment';
                            const nicknameP = document.createElement('p');
                            nicknameP.className = 'nickname';
                            nicknameP.textContent = comment.nickname;
                            const commentTextP = document.createElement('p');
                            commentTextP.className = 'comment-text';
                            commentTextP.textContent = comment.commentText;
                            commentDiv.appendChild(nicknameP);
                            commentDiv.appendChild(commentTextP);
                            commentList.appendChild(commentDiv);
                        });
                    });
            }

            loadComments(); // Carrega comentários ao carregar a página
        });
    </script>
</body>
</html>
