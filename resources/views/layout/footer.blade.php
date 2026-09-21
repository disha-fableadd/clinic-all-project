</div>

<style>
    .mobile-bottom-nav { display: none; }

    @media (max-width: 767px) {
        body { padding-bottom: calc(68px + env(safe-area-inset-bottom)); }
        .mobile-bottom-nav {
            position: fixed;
            inset: auto 0 0;
            z-index: 1040;
            display: flex;
            align-items: stretch;
            justify-content: space-around;
            min-height: 64px;
            padding: 5px 4px calc(5px + env(safe-area-inset-bottom));
            background: #fff;
            border-top: 1px solid #cfece0;
            box-shadow: 0 -2px 12px rgba(0, 0, 0, .08);
        }
        .mobile-bottom-nav a {
            display: flex;
            flex: 1;
            min-width: 0;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            color: #333;
            font-size: 11px;
            line-height: 1.2;
            text-decoration: none;
        }
        .mobile-bottom-nav a i { font-size: 19px; }
        .mobile-bottom-nav a.active { color: #26846b; font-weight: 600; }
        .mobile-bottom-nav a:focus-visible { outline: 2px solid #26846b; outline-offset: -2px; }
    }
</style>

<nav class="mobile-bottom-nav" aria-label="Mobile shortcuts">
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif>
        <i class="fa fa-home" aria-hidden="true"></i><span>Home</span>
    </a>
    @if (app('hasPermission')(6, 'view'))
        <a href="{{ route('appointment.index') }}" class="{{ request()->routeIs('appointment.*') ? 'active' : '' }}" @if(request()->routeIs('appointment.*')) aria-current="page" @endif>
            <i class="fa fa-calendar-check" aria-hidden="true"></i><span>Appointments</span>
        </a>
    @endif
    @if (app('hasPermission')(5, 'view'))
        <a href="{{ route('patients.index') }}" class="{{ request()->routeIs('patients.*') ? 'active' : '' }}" @if(request()->routeIs('patients.*')) aria-current="page" @endif>
            <i class="fa fa-user-injured" aria-hidden="true"></i><span>Patients</span>
        </a>
    @endif
    @if (app('hasPermission')(30, 'create'))
        <a href="{{ route('daily_data.create') }}" class="{{ request()->routeIs('daily_data.create') ? 'active' : '' }}" @if(request()->routeIs('daily_data.create')) aria-current="page" @endif>
            <i class="fa fa-plus-circle" aria-hidden="true"></i><span>Daily Register</span>
        </a>
    @endif
    <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}" @if(request()->routeIs('profile')) aria-current="page" @endif>
        <i class="fa fa-user" aria-hidden="true"></i><span>Profile</span>
    </a>
</nav>

<div class="sidebar-overlay" data-reff=""></div>

<!-- <script src="{{asset(env('IMAGE_PATH').'admin/assets/js/jquery-3.2.1.min.js')}}"></script> -->

<script src="{{asset(env('IMAGE_PATH').'admin/assets/js/popper.min.js')}}"></script>

<script src="{{asset(env('IMAGE_PATH').'admin/assets/js/bootstrap.min.js')}}"></script>

<script src="{{asset(env('IMAGE_PATH').'admin/assets/js/jquery.slimscroll.js')}}"></script>

<script src="{{asset(env('IMAGE_PATH').'admin/assets/js/Chart.bundle.js')}}"></script>

<script src="{{asset(env('IMAGE_PATH').'admin/assets/js/chart.js')}}"></script>

<script src="{{asset(env('IMAGE_PATH').'admin/assets/js/app.js')}}"></script>



<script src="{{asset(env('IMAGE_PATH').'admin/assets/js/moment.min.js')}}"></script>


<script src="{{asset(env('IMAGE_PATH').'admin/assets/js/fullcalendar.min.js')}}"></script>

<script src="{{asset(env('IMAGE_PATH').'admin/assets/js/jquery.fullcalendar.js')}}"></script>








<script>
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  function ajaxRequest(url, formData = null, method = "POST") {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: url,
        method: method,
        data: formData ? formData : {},
        contentType: formData ?
          false : "application/x-www-form-urlencoded; charset=UTF-8",
        processData: formData ? false : true,
        cache: false,
        success: function(response) {
          if (response.status) {
            if (response.message !== "") toastr.success(response.message || "Successful", "Success");
          } else {
            toastr.error(
              response.message || "An error occurred",
              "Error"
            );
          }
          resolve(response); // Resolve the promise with the response
        },
        error: function(xhr, status, error) {
          var errorMessage = xhr.responseJSON ?
            xhr.responseJSON.message :
            error;
          // toastr.error(errorMessage || "An error occurred", "Error");
          if (xhr.responseJSON && xhr.responseJSON.errors) {
            showValidationErrors(xhr.responseJSON.errors); // Call reusable function
          } else {
            // $("#errorMessage").text("An unexpected error occurred").show();
              Swal.fire('Error', errorMessage || "An error occurred", 'error');
          }
          reject(error); // Reject the promise with the error
        },
      });
    });
  }

  function showValidationErrors(errors) {
    $(".invalid-feedback").remove(); // Clear previous errors
    $(".form-control").removeClass("is-invalid"); // Remove invalid class

    $.each(errors, function(field, messages) {
      let inputField = $("[name='" + field + "']");
      inputField.addClass("is-invalid");
      inputField.after('<span class="invalid-feedback">' + messages[0] + "</span>");
    });
  }
</script>

<script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $('.notification-link').on('click', async function(e) {
                e.preventDefault(); // Prevent the default link behavior

                var notificationId = $(this).data('id'); // Get the notification ID
                var updateUrl = $(this).data('url'); // Get the URL for the update method
                var redirectUrl = $(this).attr('href');
console.log('notificationId', notificationId, updateUrl, redirectUrl)
                // return
                $.ajax({
                    url: updateUrl,
                    method: 'POST',
                    data: {
                        _method: 'POST',
                        read: true 
                    },
                    success: function(response) {
                        console.log('Error notification:', response.message);
                        window.location.href = redirectUrl; // Redirect to the link
                    },
                    error: function(xhr) {
                        window.location.href = redirectUrl; 
                        console.error('Error while notification:', xhr.responseText);
                    }
                });
            });
        });
    </script>

    @include('layout.chatbot')
    <!-- Copyright -->
<footer class="text-center my-3">
    <p>
        Copyright &copy; <span id="year"></span> -
        <a href="https://fableadtechnolabs.com/" target="_blank" style="text-decoration: none; color: black;">
            <b>Fablead Developers Technolab</b>
        </a>
    </p>
</footer>

<script>
    document.getElementById("year").textContent = new Date().getFullYear();
</script>

</body>





<!-- index22:59-->

</html>
