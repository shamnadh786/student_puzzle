function submitGame() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var html = "";
    if ($("#puzzleWord").val() == "") {
        alert("Please enter a word");
        return;
    }
    fetch(gameSubmitRoute, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                puzzleWord: $("#puzzleWord").val()
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                $("#puzzleWord").val('');
                $("#puzzleString").text(data.puzzleString);
                $("#score").text(data.score);
                data.submission.forEach(element => {
                    html += `
                        <li>${element.word} - ${element.score} pts</li>
                    `;
                });
                document.getElementById('submissionList').innerHTML = html;
                flash(data.message, {
                    'bgColor': 'green',
                    'vPosition': 'top',
                    'hPosition': 'right',
                });
                if (data.is_game_over) {
                    showAlert("Letters not found to make a valid word.<br>Game Over!", "error", function() {
                        window.location.href = '/finish';
                    });

                }
            } else {
                $("#puzzleWord").val('');
                flash(data.message, {
                    'bgColor': 'red',
                    'ftColor': 'white',
                    'vPosition': 'top',
                    'hPosition': 'right',
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function finishGame() {
    swal({
        title: `<h5>Are you sure you want to end this game?</h5>`,
        html: `<div>
            <button type="button" id="swalConfirm" class="btn btn-success btn-yes mr-4" style="min-width: 125px;">Yes</button>
            <button class="btn btn-danger btn-cancel" style="min-width: 125px;">Cancel</button>
        </div>`,
        type: "warning",
        showConfirmButton: false,
        showCancelButton: false,
        onBeforeOpen: () => {
            document.querySelector('#swalConfirm').addEventListener('click', () => {
                swal.close();
                window.location.href = '/finish';
            });

            document.querySelector('.btn-cancel').addEventListener('click', () => {
                swal.close();
            });
        }
    });
}

function showAlert(message, type, callback) {
    swal({
        title: "<small class='text-info'>" + message + "</small>",
        type: type,
        showConfirmButton: true,
        showCancelButton: false,

    }).then(function() {
        if (typeof callback === "function") {
            callback();
        }
    });
}