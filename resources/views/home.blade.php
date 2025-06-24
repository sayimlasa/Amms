
@extends('layouts.admin')

@section('content')

<style>
    .card{
        border-top: #10477E solid 2px;
    }
    .card-header {
        background-color: #10477E;
        color: #fff;
      
    }
    .card-header.red{
        background-color: #A41E22;
        color: #fff;
    }
</style>
 @include('dashboards.adminiDashboard')
@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js" integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthIndicator = document.getElementById('strengthIndicator');
        const strengthBar = document.getElementById('strengthBar');

        let strength = 0;
        if (password.length > 5) strength += 1;
        if (password.match(/[A-Z]/)) strength += 1;
        if (password.match(/[0-9]/)) strength += 1;
        if (password.match(/[@$!%*?&]/)) strength += 1;

        // Update strength bar
        strengthBar.style.width = `${strength * 25}%`;

        // Update text
        switch (strength) {
            case 1:
                strengthIndicator.textContent = 'Weak';
                strengthBar.style.backgroundColor = 'red';
                break;
            case 2:
                strengthIndicator.textContent = 'Fair';
                strengthBar.style.backgroundColor = 'orange';
                break;
            case 3:
                strengthIndicator.textContent = 'Good';
                strengthBar.style.backgroundColor = 'yellow';
                break;
            case 4:
                strengthIndicator.textContent = 'Strong';
                strengthBar.style.backgroundColor = 'green';
                break;
            default:
                strengthIndicator.textContent = '';
                strengthBar.style.backgroundColor = '';
                break;
        }
    }
</script>
 
@endsection