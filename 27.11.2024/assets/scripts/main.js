$(document).ready(function () {
    // Walidacja formularza logowania
    $("#loginForm").validate({
        rules: {
            username: {
                required: true,
                minlength: 5
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            username: {
                required: "Proszę wprowadzić nazwę użytkownika",
                minlength: "Nazwa użytkownika musi mieć co najmniej 5 znaków"
            },
            password: {
                required: "Proszę wprowadzić hasło",
                minlength: "Hasło musi mieć co najmniej 6 znaków"
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).css('background-color', '#ffdddd');
        },
        unhighlight: function (element) {
            $(element).css('background-color', '#ffffff');
        }
    });

    // Walidacja formularza dodawania postu
    $("#addPostForm").validate({
        rules: {
            title: {
                required: true,
                minlength: 3
            },
            content: {
                required: true,
                minlength: 10
            }
        },
        messages: {
            title: {
                required: "Proszę wprowadzić tytuł",
                minlength: "Tytuł musi mieć co najmniej 3 znaki"
            },
            content: {
                required: "Proszę wprowadzić treść",
                minlength: "Treść musi mieć co najmniej 10 znaków"
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).css('background-color', '#ffdddd');
        },
        unhighlight: function (element) {
            $(element).css('background-color', '#ffffff');
        }
    });

    // Walidacja formularza edytowania postu
    $("#editPostForm").validate({
        rules: {
            title: {
                required: true,
                minlength: 3
            },
            content: {
                required: true,
                minlength: 10
            }
        },
        messages: {
            title: {
                required: "Proszę wprowadzić tytuł",
                minlength: "Tytuł musi mieć co najmniej 3 znaki"
            },
            content: {
                required: "Proszę wprowadzić treść",
                minlength: "Treść musi mieć co najmniej 10 znaków"
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).css('background-color', '#ffdddd');
        },
        unhighlight: function (element) {
            $(element).css('background-color', '#ffffff');
        }
    });
});
