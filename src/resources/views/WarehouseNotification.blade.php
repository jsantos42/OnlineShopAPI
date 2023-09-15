<x-mail::message>
# New Order Placed

We just received a new order, let's ship it!

<x-mail::table >
    | Quantity | Name | Price |
    | :-------------: | :-------------: | :-------------: |
    @foreach($products as $product)
        | {{ $product['quantity'] }} | {{ $product['name'] }}  | {{ $product['price'] }} |
   @endforeach
</x-mail::table>

Thank you,<br>
Customer Service Team
</x-mail::message>
