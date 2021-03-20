$(document).ready(function () {

    jQuery.fn.center = function () {
        this.css("position", "fixed");
        this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 3)) + "px");
        this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2)) + "px");
        return this;
    }

    $(".container").center();

    var logIn = true;

    $(".switch").click(function () {

        if (logIn != true) {

            logIn = true;
            $(".switch").html("Sign up");
            $(".w-message").html("Log in using your username and password.");
            $("#submit").html("Log in!");
            $("#email").val("");
            $("#password").val("");
            $("#notification").html("");
            $("#email").tooltip('dispose');
            $("#password").tooltip('dispose');

            $("#signup").attr('value', '0');

            //removing confirmPassword input because it's login form
            $("#passwordConfirm").tooltip('dispose');
            $("#conf-group").remove();
        } else {

            logIn = false;
            $(".switch").html("Log in");
            $(".w-message").html("Interested? Sign up now.");
            $("#submit").html("Sign Up!");
            $("#email").val("");
            $("#password").val("");
            $("#notification").html("");
            $("#email").tooltip('dispose');
            $("#password").tooltip('dispose');

            //adding confirmPassword input to form
            var confPass = document.createElement('div');
            confPass.setAttribute('class', 'form-group');
            confPass.setAttribute('id', 'conf-group');
            // confPass.setAttribute('id', 'passwordConfirm');
            confPass.innerHTML = "<input id='passwordConfirm' class='form-control' placeholder='Password Confirm' type='password' name='passwordConfirm' data-toggle='tooltip' data-placement='right' title='Confirm is required!'>";

            $("#signup").attr('value', '1');

            $("#passwordDiv").after(confPass);
        }
    });



    $("form").submit(function (e) {

        var errorCounter = 0;

        if (!$("#email").val()) {

            $("#email").tooltip('show');
            errorCounter++;
        }
        if (!$("#password").val()) {

            $("#password").tooltip('show');
            errorCounter++;
        }
        if (!$("#passwordConfirm").val() && !logIn) {

            $("#passwordConfirm").tooltip('show');
            errorCounter++;
        }
        if ($("#password").val() !== $("#passwordConfirm").val() && !logIn) {

            if (!$("#passwordAlert").length) {
                var error = document.createElement('div');
                error.setAttribute('class', 'alert alert-danger');
                error.setAttribute('role', 'alert');
                error.setAttribute('id', 'passwordAlert');
                error.innerHTML = "Passwords do not match!";
                $("#passwordConfirm").after(error);
            }

            errorCounter++;
        } else {
            $("#passwordAlert").remove();
        }
        if (errorCounter > 0) {

            return false;
        } else {

            return true;
        }

    });

});