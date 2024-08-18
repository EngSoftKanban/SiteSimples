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

<<<<<<< HEAD
<<<<<<< HEAD
            // Lê os comentários de um arquivo de texto e os exibe
=======
            // Lê os comentários de um arquivo de texto
>>>>>>> feature_branch3
=======
            // Lê os comentários de um arquivo de texto
>>>>>>> feature_branch3
            if(file_exists('comments.txt')){
                $comments = file('comments.txt');
                $index = 0;
                foreach ($comments as $comment) {
                    list($nickname, $commentText) = explode('|', $comment);
<<<<<<< HEAD
<<<<<<< HEAD
                    $index++;
                    echo "<div class='comment' id='comment_$index'>";
                    echo "<p class='nickname'>$nickname</p>";
                    echo "<p class='comment-text'>$commentText</p>";
                    echo "<button class='change-color'>Mudar Cor</button>";
                    echo "</div>";
=======
                    echo "<div class='comment'><p class='nickname'>$nickname</p><p class='comment-text'>$commentText</p></div>";
>>>>>>> feature_branch3
=======
                    echo "<div class='comment'><p class='nickname'>$nickname</p><p class='comment-text'>$commentText</p></div>";
>>>>>>> feature_branch3
                }
            }
            ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentForm = document.getElementById('commentForm');
            const commentList = document.getElementById('commentList');

<<<<<<< HEAD
<<<<<<< HEAD
            // Cores para os comentários, incluindo a cor padrão
            const colors = ['#ebf3e7', '#e7ebf3', '#f3e7eb', '#f3f3e7'];

            // Função para adicionar evento de mudança de cor
            function addColorChangeEvent(button, commentDiv) {
                button.addEventListener('click', function() {
                    changeColor(commentDiv);
                });
            }

            // Função para mudar a cor do comentário
            function changeColor(commentDiv) {
                let currentColor = window.getComputedStyle(commentDiv).backgroundColor;

                // Mapeia a cor RGB para a cor hexadecimal correspondente
                let colorHex = rgbToHex(currentColor);

                let currentColorIndex = colors.indexOf(colorHex);

                // Se a cor atual não está na lista, considera que está na primeira cor
                if (currentColorIndex === -1) {
                    currentColorIndex = 0;
                }

                // Próxima cor na lista
                let nextColorIndex = (currentColorIndex + 1) % colors.length;

                commentDiv.style.backgroundColor = colors[nextColorIndex];
            }

            // Função para converter a cor RGB em hexadecimal
            function rgbToHex(rgb) {
                const rgbArray = rgb.match(/\d+/g).map(Number);
                return `#${rgbArray.map(x => x.toString(16).padStart(2, '0')).join('')}`;
            }

            // Função para carregar e renderizar os comentários
            function loadComments() {
                fetch('get_comments.php')
                    .then(response => response.json())
                    .then(comments => {
                        commentList.innerHTML = '';
                        comments.forEach((comment, index) => {
                            const commentDiv = document.createElement('div');
                            commentDiv.className = 'comment';
                            commentDiv.id = `comment_${index + 1}`;

                            const nicknameP = document.createElement('p');
                            nicknameP.className = 'nickname';
                            nicknameP.textContent = comment.nickname;

                            const commentTextP = document.createElement('p');
                            commentTextP.className = 'comment-text';
                            commentTextP.textContent = comment.commentText;

                            const changeColorButton = document.createElement('button');
                            changeColorButton.className = 'change-color';
                            changeColorButton.textContent = 'Mudar Cor';

                            addColorChangeEvent(changeColorButton, commentDiv);

                            commentDiv.appendChild(nicknameP);
                            commentDiv.appendChild(commentTextP);
                            commentDiv.appendChild(changeColorButton);
                            commentList.appendChild(commentDiv);
                        });
                    });
            }

            // Função para adicionar um novo comentário à lista
            function addComment(nickname, commentText) {
                const commentDiv = document.createElement('div');
                commentDiv.className = 'comment';
                commentDiv.style.backgroundColor = colors[0]; // Inicia com a cor padrão

                const nicknameP = document.createElement('p');
                nicknameP.className = 'nickname';
                nicknameP.textContent = nickname;

                const commentTextP = document.createElement('p');
                commentTextP.className = 'comment-text';
                commentTextP.textContent = commentText;

                const changeColorButton = document.createElement('button');
                changeColorButton.className = 'change-color';
                changeColorButton.textContent = 'Mudar Cor';

                addColorChangeEvent(changeColorButton, commentDiv);

                commentDiv.appendChild(nicknameP);
                commentDiv.appendChild(commentTextP);
                commentDiv.appendChild(changeColorButton);
                commentList.insertBefore(commentDiv, commentList.firstChild);
            }

            // Evento de envio do formulário
=======
>>>>>>> feature_branch3
=======
>>>>>>> feature_branch3
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
<<<<<<< HEAD
<<<<<<< HEAD
                        addComment(nickname, commentText);
=======
=======
>>>>>>> feature_branch3
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

<<<<<<< HEAD
>>>>>>> feature_branch3
=======
>>>>>>> feature_branch3
                        commentForm.reset();
                    }
                });
            });

<<<<<<< HEAD
<<<<<<< HEAD
            // Carrega os comentários ao iniciar
            loadComments();
=======
=======
>>>>>>> feature_branch3
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
<<<<<<< HEAD
>>>>>>> feature_branch3
=======
>>>>>>> feature_branch3
        });
    </script>
</body>
</html>
