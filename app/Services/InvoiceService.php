<?php

namespace Modules\Invoice\Services;

use Exception;
use Modules\Invoice\Models\Invoice;
use Modules\Order\Models\Order;

class InvoiceService
{
    /**
     * Create a new invoice for an order.
     *
     * @throws Exception
     */
    public function createInvoice(Order $order): Invoice
    {
        try {
            // Create the invoice based on order data
            $invoice = $order->invoice()->create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'status' => 'pending', // Default status
                'sub_total' => $order->total_amount,
                'discount' => 0, // You can add logic for discounts
                'shipping' => 0, // Add logic for shipping charges
                'taxes' => $this->calculateTaxes($order),
                'total_amount' => $order->total_amount, // Adjust based on discounts/taxes
                'invoice_to' => $order->shipping_address, // Add more logic if necessary
                'create_date' => now(),
                'due_date' => now()->addDays(30), // Example: invoice due in 30 days
            ]);

            return $invoice;
        } catch (Exception $e) {
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    /**
     * Generate a unique invoice number.
     */
    private function generateInvoiceNumber(): string
    {
        return 'INV-'.now()->format('Ymd').strtoupper(bin2hex(random_bytes(4)));
    }

    /**
     * Calculate taxes based on the order amount.
     * (You can extend this with a more complex tax calculation if necessary.)
     */
    private function calculateTaxes(Order $order): float
    {
        // For simplicity, assuming a fixed 10% tax rate
        return $order->total_amount * 0.1;
    }

    /**
     * Update the invoice status.
     */
    public function updateInvoiceStatus(Invoice $invoice, string $status): void
    {
        $invoice->update(['status' => $status]);
    }

    /**
     * Paid the invoice status.
     */
    public function markInvoicePaid(Invoice $invoice): void
    {
        $this->updateInvoiceStatus($invoice, 'paid');
    }
}
