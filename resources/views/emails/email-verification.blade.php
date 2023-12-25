<div class="container">
    <h1>Verify your email</h1>
    <p>Enter this code in your application in order to verify your email</p>
    <button class="code">{{$code}}</button>
</div>

<style>
    .container {
        padding: 20px;
        text-align: center;
    }

    p {
        font-size: 1.5rem;
    }

    .code {
        outline: none;
        border-radius: 20px;
        border: none;
        background-color: black;
        color: white;
        font-size: 2rem;
        padding: 20px 50px;
    }
</style>