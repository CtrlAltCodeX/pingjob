<html>

<body>

    <div
        style="height:20px;width:100%;max-width: 600px;background-color:#38c172;display: flex;justify-content: space-around;align-items: center;">
    </div>

    <div style="width:100%;max-width: 600px;display: flex;justify-content: space-around;align-items: center;">
        <img style='width: 187px' src="{{ asset('assets/images/LOGO-FINAL-PNG.png') }}">
        {{-- <img style='width: 187px' src="https://pingjob.com/assets/images/logo.png"> --}}
    </div>

    <div
        style="height:20px;width:100%;max-width: 600px;background-color:#38c172;display: flex;justify-content: space-around;align-items: center;">
    </div>

    <div style='max-width: 600px;'>

        <div>
            <h2 style='display: flex;justify-content: space-around;color: #38c172'>A new job opportunity for you!</h2>
        </div>
        <br>
        <div>{{ $data['company_name'] }} requires {{ $data['position'] }} for their company located in
            {{ $data['city_name'] }}, {{ $data['state_name'] }}, {{ $data['country_name'] }}</div>
        <br>
        <div>The salary they are offering for this post is: {{ $data['salary_currency'] }} {{ $data['salary'] }},
            {{ $data['salary_cycle'] }} and experiance required from the client for this desired job is
            {{ $data['experience_requirements'] }}</div>
        <br>
        <div><span style='font-weight:bold'>Requirements:</span> {{ $data['description'] }}</div>
        <div><span style='font-weight:bold'>Skills:</span> {{ $data['skills'] }}</div>
    </div>

    <br>
    <div
        style="height:100px;width:100%;max-width: 600px;background-color:#38c172;display: flex;justify-content: space-around;align-items: center;">
        <p style='color: white;font-size: 10px;margin: auto'>Copyright © 2021 PingJob, all rights reserved.</p>
    </div>
</body>


</html>
