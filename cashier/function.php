<?php
// functions.php - Collection of functions & procedures

// Sanitize input
function sanitize($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

// Format number to Rupiah
function rupiah($number) {
    return number_format($number, 0, ',', '.');
}

// Calculate subtotal
function hitung_subtotal($harga, $qty) {
    return $harga * $qty;
}

// Calculate total from cart
function hitung_total($cart) {
    $total = 0;
    foreach ($cart as $item) {
        $total += hitung_subtotal($item['price'], $item['qty']);
    }
    return $total;
}

 
function hitung_discount($total) {
    if ($total >= 200000) {
        return 0.15 * $total;
    }
     elseif ($total >= 100000) {
         return 0.10 * $total;
     }
     elseif ($total >= 50000) {
         return 0.05 * $total;
     }
      
    return 0;
}

// 11% tax after discount
function hitung_pajak($total_after_discount) {
    return 0.11 * $total_after_discount;
}

// Grand total
function hitung_grand_total($total, $discount, $tax) {
    return $total - $discount + $tax;
}

// PROCEDURE (without return value) to display a simple alert
function print_alert($msg) {
    echo "<div style='background:#fff3cd;border:1px solid #ffeeba;padding:8px;margin:10px 0;'>"
        . sanitize($msg) . "</div>";
}

// PROCEDURE to render cart table
function render_table_cart($cart) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<thead><tr><th>No</th><th>Name</th><th>Price (Rp)</th><th>Qty</th><th>Subtotal</th><th>Action</th></tr></thead><tbody>";

    if (empty($cart)) {
        echo "<tr><td colspan='5' style='text-align:center;color:#888;'>No items yet</td></tr>";
    } else {
        $no = 1;
        foreach ($cart as $index => $item) {
            $subtotal = hitung_subtotal($item['price'], $item['qty']);
            echo "<tr>";
            echo "<td>{$no}</td>";
            echo "<td>" . sanitize($item['name']) . "</td>";
            echo "<td>" . rupiah($item['price']) . "</td>";
            echo "<td>{$item['qty']}</td>";
            echo "<td>" . rupiah($subtotal) . "</td>";
             echo "<td> <a href='index.php?action=delete&index={$index}'> Delete  </a> </td>";
            echo "</tr>";
            $no++;
        }
    }
    echo "</tbody></table>";
}

// PROCEDURE to render HTML receipt
function render_struk($cart) {
    $total = hitung_total($cart);
    $discount = hitung_discount($total);
    $after = $total - $discount;
    $tax = hitung_pajak($after);
    $grand = hitung_grand_total($total, $discount, $tax);

    echo "<div style='border:1px dashed #333;padding:12px;max-width:520px;background:#fafafa;'>";
    echo "<h3 style='margin:0 0 8px 0;'>Purchase Receipt</h3>";
    echo "<small>Cashier: demo | Date: " . date('Y-m-d H:i') . "</small><hr/>";
    echo "<ol style='padding-left:20px;'>";

    foreach ($cart as $item) {
        echo "<li>" . sanitize($item['name']) . " — {$item['qty']} x " . rupiah($item['price']) .
             " = <strong>" . rupiah(hitung_subtotal($item['price'], $item['qty'])) . "</strong></li>";
    }

    echo "</ol><hr/>";
    echo "<div style='text-align:right'>";
    echo "Subtotal: <strong>" . rupiah($total) . "</strong><br/>";
    echo "Discount: <strong>- " . rupiah($discount) . "</strong><br/>";
    echo "VAT 11%: <strong>" . rupiah($tax) . "</strong><br/>";
    echo "<hr style='border-top:1px solid #333'/>";
    echo "<div style='font-size:1.1em;'>Grand Total: <strong>" . rupiah($grand) . "</strong></div>";
    echo "</div></div>";
}
?>
