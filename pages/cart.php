<?php
include __DIR__ . '/../partials-front/menu.php';
require_once __DIR__ . '/../connection.php';
?>

<?php
 if (isset($_SESSION['cart'])) {
$cart =  $_SESSION['cart'];
?>
<div class="cartcontainer">
    <h2 class='heading'>Your Cart</h2>
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php
        $total = 0;
        $totalitems = 0;
        foreach ($cart as $key => $value) {
            //echo $key ." : ". $row['title'] . "<br>";
            $sql = "SELECT * FROM product where id = $key";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result)
        ?>
            <tr>
                <td>
                    <div class="cart-info">
                        <img src="<?= BASE_URL ?>images/product/<?php echo $row['image_name']; ?>" height="150px" />
                        <div class="title">
                            <a href="singleproduct.php?id=<?php echo $row['id'] ?>"><?php echo $row['title'] ?></a>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="price">₹ <?php echo $row['price']; ?></div>
                </td>
                <td>
                    <div class="counter" data-id="<?php echo $key; ?>"> <button class="btn-dec">−</button>
                    <span class="quantity" style="min-width:40px; padding:0 6px; user-select:none;"><?php echo $value['quantity']; ?></span>
                    <button class="btn-inc">+</button> </div>
                </td>
                <td>
                    <div class="price2">₹ <?php echo $row['price'] * $value['quantity']; ?>.00 </div>
                </td>
                <td>
                    <div class="remove"> <a href='deletecart.php?id=<?php echo $key; ?>'>Remove</a></div>
                </td>
            </tr>
        <?php
            $total = $total +  ($row['price'] * $value['quantity']);
            $totalitems = $totalitems + $value['quantity'];
        }
        ?>
    </table>
    <hr>
    <div class="checkout">
        <div class="total">
            <div>
                <div class="Subtotal">Total Amount:</div>
                <div class="items"><?php echo $totalitems; ?> items</div>
            </div>
            <div class="total-amount">₹ <?php echo $total; ?>.00</div>
        </div>
        <a href="checkout.php"> <button class="button">Checkout</button></a>
    </div>
</div>

<?php
    }
  else{
      ?>
    <div class="cartcontainer">
    <h2 class='heading'>Your Cart</h2>
<h3 class="billing">No items in your cart.</h3>
 <?php }?>
<div class="space"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.counter').forEach(counter => {
    const dec = counter.querySelector('.btn-dec');
    const inc = counter.querySelector('.btn-inc');
    const qtyEl = counter.querySelector('.quantity');

    if (dec) dec.addEventListener('click', () => changeQty(counter, qtyEl, -1));
    if (inc) inc.addEventListener('click', () => changeQty(counter, qtyEl,  1));
  });

  function parseRupees(text) {
    return parseFloat((text || '').replace(/[^\d.]/g, '')) || 0;
  }
  function formatRupees(num) {
    return '₹ ' + Number(num).toFixed(2);
  }

function changeQty(counter, qtyEl, delta) {
  let qty = parseInt(qtyEl.textContent || '1', 10);
  qty = qty + delta;

  const id = counter.dataset.id;

  if (qty <= 0) {
    const row = counter.closest('tr');
    if (row) row.remove();

    fetch('updatecart.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ remove: id })
    });
    recomputeSummary();
    return;
  }

  qtyEl.textContent = qty;

  const row = counter.closest('tr');
  const unitPriceCell = row.querySelector('.price');
  const rowTotalCell  = row.querySelector('.price2');

  const unit = parseRupees(unitPriceCell ? unitPriceCell.textContent : '0');
  const rowTotal = unit * qty;
  if (rowTotalCell) rowTotalCell.textContent = formatRupees(rowTotal);

  recomputeSummary();

  fetch('updatecart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ items: { [id]: qty } })
  });
}


  function recomputeSummary() {
    let items = 0;
    document.querySelectorAll('span.quantity').forEach(q => {
      items += parseInt(q.textContent || '0', 10) || 0;
    });

    let amount = 0;
    document.querySelectorAll('.price2').forEach(cell => {
      amount += parseRupees(cell.textContent);
    });

    const itemsEl = document.querySelector('.items');
    if (itemsEl) itemsEl.textContent = items + ' items';

    const totalAmountEl = document.querySelector('.total-amount');
    if (totalAmountEl) totalAmountEl.textContent = formatRupees(amount);
  }

  function collectItems() {
    const items = {};
    document.querySelectorAll('.counter').forEach(counter => {
      const id  = counter.dataset.id;
      const qty = parseInt(counter.querySelector('.quantity').textContent || '1', 10);
      if (id) items[id] = Math.max(1, qty);
    });
    return items;
  }

  const checkoutBtn = document.querySelector('.checkout .button');
  if (checkoutBtn) {
    checkoutBtn.addEventListener('click', async (e) => {
      e.preventDefault();

      const items = collectItems();
      try {
        const res = await fetch('updatecart.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ items })
        });

        const data = await res.json();
        if (res.ok && data.ok) {
          window.location.href = 'checkout.php';
        } else {
          alert('Could not update cart. Please try again.');
        }
      } catch (err) {
        alert('Network error while updating cart.');
      }
    });
  }
});
</script>


<?php include __DIR__ . '/../partials-front/footer.php';  ?>