<x-mail::message>
# Order Confirmed

Your order is being processed!

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
