<div class="container">
    <h1>Order created successfully</h1>
    <p>An order with the following details has been added in your name</p>
    <ul>
        <li>id: {{$order->id}}</li>
        <li>address: {{$order->address}}</li>
        <li>ville: {{$order->ville}}</li>
        <li>zipcode: {{$order->zipcode}}</li>
    </ul>
        
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