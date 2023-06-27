<html>
<style>
    @media only screen and (max-width: 500px) {
        * {
            font-size: 10px;
        }
    }
</style>

<body style="background: #181624; color:white;font-family: 'Montserrat', sans-serif; word-wrap: break-word; ">
    <div style="padding:3% 9%">
        <div style="text-align: center;font-size: 12px;margin-bottom: 75px">
            <h1 style="color:#DDCCAA; font-weight: 500">Movie quotes/h1>
        </div>
        <p style="margin-bottom: 26px">Hello ! </p>
        <p style="margin-bottom: 34px"> Thanks for joining Movie quotes! We really appreciate it. Please click the
            button below to verify your account:
        </p>
        <a href="{{ $url }}" style="max-width: 200px; padding:7px 13px;color:white;background:#E31221;text-decoration: none;font-weight: 400;
            border-radius:4px">Verify account</a>
        <p style="margin-bottom: 24px; margin-top:40px">If clicking doesn't work, you can try copying and pasting it to
            your browser:</p>
        <a href="{{ $url }}" style="margin-bottom: 40px;color:#DDCCAA;text-decoration: none;cursor: pointer">
            {{ $url }}</a>
        <p style="margin-bottom: 24px">If you have any problems, please contact us: support@moviequotes.ge</p>
        <p>MovieQuotes Crew</p>
    </div>
</body>

</html>