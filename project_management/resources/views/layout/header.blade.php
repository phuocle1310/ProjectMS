<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="#"><img src="{{asset('/images/logo.svg')}}" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="#"><img src="{{asset('/images/logo-mini.svg')}}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                <div class="input-group">
                    <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                  <i class="icon-search"></i>
                </span>
                    </div>
                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                   <!-- <img src="${doctor.image}" alt="profile"/> -->
                    <strong>{{ auth()->user()->role->role }}: {{ auth()->user()->name }}</strong>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item">
                        <i class="ti-settings text-primary"></i>
                        Settings
                    </a>
                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#mymodal" data-whatever="changePassword">
                        <i class="ti-key text-primary"></i>
                        Change Password
                    </button>
                    <a class="dropdown-item" href="{{asset('/logout')}}">
                        <i class="ti-power-off text-primary"></i>Logout
                    </a>
                </div>
                </li>
            <li class="nav-item nav-settings d-none d-lg-flex">
                <a class="nav-link" href="#">
                    <i class="icon-ellipsis"></i>
                </a>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>

<!-- This is modal Change password -->

<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formChangePassword" action="{{ route('user.changePassword', auth()->user()->id) }}" method="patch" onsubmit="return false;">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="current-password" class="col-form-label">Current Password:</label>
                <input type="password" name="password" class="form-control" id="current-password" required="true" />
                    <div id="errorCurrentPassword"></div>
            </div>
            <div class="form-group">
                <label for="new-password" class="col-form-label">New Password:</label>
                <input type="password" name="newPassword" class="form-control" id="new-password" required="true" />
                    <div id="errorNewPassword"></div>
            </div>
            <div class="form-group">
                <label for="confirm-password" class="col-form-label">Confirm Password:</label>
                <input type="password" name="confirmPassword" class="form-control" id="confirm-password" required="true"/>
                <div id="errorConfirmPassword"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="CancelChangePassword()">Cancel</button>
            <button type="submit" class="btn btn-primary" onclick="changePassword()">Change</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    formChangePassword = document.getElementById('formChangePassword');
    var url = formChangePassword.getAttribute('action');
    var method = formChangePassword.getAttribute('method');
    
    changePassword = function() {
        let currentPassword = document.getElementById('current-password').value;
        let newPassword = document.getElementById('new-password').value;
        let confirmPassword = document.getElementById('confirm-password').value;
        let data = {};
        data['password'] = currentPassword;
        data['newPassword'] = newPassword;
        data['confirmPassword'] = confirmPassword;
        $.ajax({
            type: method,
            url: url,
            data: data,
            success: function (data, status) {
                alert('success-message', 0);
                CancelChangePassword();
            },
            error: function (xhr, data, status) {
                let currentPassword = document.getElementById('errorCurrentPassword');
                let newPassword = document.getElementById('errorNewPassword');
                let confirmPassword = document.getElementById('errorConfirmPassword');
                if(xhr.responseJSON in xhr.responseJSON) {
                    if(!(xhr.responseJSON.errors.password in xhr.responseJSON.errors))
                        currentPassword.innerText = "";
                    if(!(xhr.responseJSON.errors.newPassword in xhr.responseJSON.errors))
                        newPassword.innerText = "";
                    if(!(xhr.responseJSON.errors.confirmPassword in xhr.responseJSON.errors))
                        confirmPassword.innerText = "";
                

                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        switch(key) {
                            case "password":
                                if(item != null && item != "")
                                    currentPassword.insertAdjacentHTML("beforeend", "<span class=\"text-danger\">"+item+"</span>");
                                break;
                            case "newPassword":
                                if(item != null && item != "")
                                    newPassword.insertAdjacentHTML("beforeend", "<span class=\"text-danger\">"+item+"</span>");
                                break;
                            case "confirmPassword":
                                if(item != null && item != "")
                                    confirmPassword.insertAdjacentHTML("beforeend", "<span class=\"text-danger\">"+item+"</span>");
                                break;
                            default:
                                // code block
                            }
                    });
                }
                alert('title-and-text', 0);
            },
        });
    };
    CancelChangePassword = function() {
        currentPassword = document.getElementById('current-password').value = "";
        newPassword = document.getElementById('new-password').value = "";
        confirmPassword = document.getElementById('confirm-password').value = "";

        errCurrentPassword = document.getElementById('errorCurrentPassword').innerText = "";
        errNewPassword = document.getElementById('errorNewPassword').innerText = "";
        errConfirmPassword = document.getElementById('errorConfirmPassword').innerText = "";
    };
</script>