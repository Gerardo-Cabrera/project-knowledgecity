var checkRem = $("#remember");
var user = $("#username");
var logged = false;
var urlAuth = "api/auth.php";
var urlUsers = "api/users.php";
var usersList = "";
var page = 1;
var rows = 5;
var windowPage = 5;

function login() {
    $("#btn-login").on("click", function(event) {
        if (validationsLogin()) {
            if (checkRem.prop("checked")) {
                localStorage.remember = true;
            }
            auth();
        }
    });
}

function logout() {
    $("#btn-logout").on("click", function(event) {
        closeSession();
    });
}

function closeSession() {
    $.ajax({
        url: urlAuth,
        method: "DELETE",
        success: function(result) {
            localStorage.clear();
            var page = "login.html";
            window.location.replace(page);
        }
    });
}

function lsRememberMe() {
    if (checkRem.is(":checked") && user.val() !== "") {
      localStorage.username = user.val();
      localStorage.checkbox = checkRem.val();
    } else {
      localStorage.username = "";
      localStorage.checkbox = "";
    }
}

function validationsLogin() {
    var username = $("#username").val(); 
    var password = $("#password").val();
    var result = false;


    if (username == "" || password == "") {
        var message = "Must fill the fields";
        $("#message-login").contents().remove();
        $("#message-login").append(message);
        $("#message-login").addClass("alert-danger");
        $("#message-login").show();

        setTimeout(function() {
            $("#message-login").hide();
            $("#message-login").contents().remove();
        }, 3000);
    } else {
        result = true;
    }

    return result;
}

function auth() {
	var credentials = {
		username: $("#username").val(),
		password: $("#password").val()
	};

	$.post(urlAuth, credentials).done(function(data) {
		if (data.status == 1) {
            localStorage.logged = true;
            listUsers();
		} else {
			$("#message-login").contents().remove();
			$("#message-login").append(data.message);
			$("#message-login").addClass("alert-danger");
			$("#message-login").show();

			setTimeout(function() {
				$("#message-login").hide();
				$("#message-login").contents().remove();
			}, 3000);
		}
	});
}

function listUsers() {
    $.get(urlUsers, function(data) {
        localStorage.listUsers = JSON.stringify(data.list_users);

        var page = "list.html";
        window.location.replace(page);
    }, "json");
}

function buildTable() {
    var listUsers = JSON.parse(localStorage.listUsers);

    if (Object.keys(listUsers).length > 0) {
        var tableBody = $("#tableBody");

        for (i = 0; i < listUsers.length; i++) {
            var row = `<tr>
                            <td class="td-image"><img class="img-width" src='assets/images/check.svg'></td>
                            <td class="font-td"><label class="label-name">${listUsers[i].name} ${listUsers[i].lastname}</label><label class="label-username">${listUsers[i].username}</label></td>
                            <td></td>
                            <td><label class="label-group">${listUsers[i].student_group}</label><label class="label-dots">...</label></td>
                       </tr>`
            tableBody.append(row);
        }
    }
}

function pagination() {
    var table = "#tableUsers";
    $(".pagination").html("");
    var trNum = 0;
    var maxRows = rows;
    var listUsers = JSON.parse(localStorage.listUsers);
    var totalRows = Object.keys(listUsers).length;

    $(table + ' tr:gt(0)').each(function() {
        trNum++;

        if (trNum > maxRows) {
            $(this).hide();
        }

        if (trNum <= maxRows) {
            $(this).show();
        }
    });

    var totalPages = Math.ceil(totalRows / maxRows);

    for (var i = 1; i <= totalPages;) {
        $('.pagination').append('<li data-page="' + i + '" class="page-item">\<a class="page-link item-link item-active" href="#">' + i++ + '<span class"sr-only"(current)</span></a></li>').show();
    }

    if (page != totalPages) {
        $('.pagination').append('<li data-page="' + page + '" class="page-item next" aria-disabled="true">\<a class="page-link item-link" href="#"> Next &#187; <span class"sr-only"(current)</span></a></li>').show();
    }

    $('.pagination li:first-child').addClass('active');
    $('.pagination li').on('click', function(e) {
        var pageNum = $(this).attr('data-page');
        var currentPage = 0;
        var trIndex = 0;

        if ($(this).hasClass('next')) {
            currentPage = page + parseInt(pageNum);
            pageNum++;
            $(this).attr('data-page', currentPage);
            $('.pagination li').removeClass('active');
            $('.pagination li[data-page="' + currentPage +'"').addClass('active');
            $(this).removeClass('active');
        } else {
            currentPage = 0;
            $('.pagination li').removeClass('active');
            $(this).addClass('active');
            $('.pagination li.next').attr('data-page', pageNum);
            $('.pagination li.next').removeClass('disabled');
            $('.pagination li.next a').removeClass('disabled');
        }

        if (pageNum == totalPages) {
            $('.pagination li.next').removeClass('active');
            $('.pagination li.next').addClass('disabled');
            $('.pagination li.next a').addClass('disabled');
            e.preventDefault();
        }

        $(table + ' tr:gt(0)').each(function() {
            trIndex++;

            if (trIndex > (maxRows * pageNum) || trIndex <= ((maxRows * pageNum) - maxRows)) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
}

$(function() {
    $("#message-login").hide();
    login();
    logout();

    if ((window.location.pathname.split("/")[2] === "list.html" && localStorage.logged) || localStorage.remember) {
        var timeWait = 60000;
        setTimeout(function() {
            listUsers();
        }, timeWait);

        buildTable();
        pagination();
    } else if (window.location.pathname.split("/")[2] === "list.html" && localStorage.logged == undefined) {
        var page = "login.html";
        window.location.replace(page);
    }

    if (window.location.pathname.split("/")[2] === "login.html" && localStorage.logged) {
        console.log("login");
        var page = "list.html";
        window.location.replace(page);
    }
});