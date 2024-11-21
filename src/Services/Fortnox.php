<?php

namespace Warbio\Fortnox\Services;
use Warbio\Fortnox\Resources\Employee\AttendanceTransactions;
use Warbio\Fortnox\Resources\Employee\AbsenceTransactions;
use Warbio\Fortnox\Resources\Account\Accounts;
use Warbio\Fortnox\Resources\Article\Articles;
use Warbio\Fortnox\Resources\CostCenter\CostCenters;
use Warbio\Fortnox\Resources\Currency\Currencies;
use Warbio\Fortnox\Resources\Customer\Customers;
use Warbio\Fortnox\Resources\Employee\Employees;
use Warbio\Fortnox\Resources\FinancialYear\FinancialYears;
use Warbio\Fortnox\Resources\Invoice\InvoiceAccruals;
use Warbio\Fortnox\Resources\Invoice\InvoicePayments;
use Warbio\Fortnox\Resources\Inbox\Inbox;
use Warbio\Fortnox\Resources\Invoice\Invoices;
use Warbio\Fortnox\Resources\Supplier\SupplierInvoiceFileConnections;
use Warbio\Fortnox\Resources\Price\PriceLists;
use Warbio\Fortnox\Resources\Project\Projects;
use Warbio\Fortnox\Resources\Employee\ScheduleTimes;
use Warbio\Fortnox\Resources\Employee\SalaryTransactions;
use Warbio\Fortnox\Resources\Supplier\SupplierInvoices;
use Warbio\Fortnox\Resources\Supplier\Suppliers;
use Warbio\Fortnox\Resources\Template\PrintTemplates;
use Warbio\Fortnox\Resources\Terms\TermsOfDeliveries;
use Warbio\Fortnox\Resources\Terms\TermsOfPayments;
use Warbio\Fortnox\Resources\Unit\Units;
use Warbio\Fortnox\Resources\Voucher\VoucherSeries;
use Warbio\Fortnox\Resources\Voucher\Vouchers;
use Warbio\Fortnox\Services\Client;

class Fortnox
{

    protected $client;

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * Returns the accounts resource.
     *
     * @return \Warbio\Fortnox\Resources\Account\Accounts
     */
    public function accounts()
    {
        return new Accounts($this->client);
    }

    /**
     * Returns the articles resource.
     *
     * @return \Warbio\Fortnox\Resources\Article\Articles
     */
    public function articles()
    {
        return new Articles($this->client);
    }

    /**
     * Returns the cost centers resource.
     *
     * @return \Warbio\Fortnox\Resources\CostCenter\CostCenters
     */
    public function costCenters()
    {
        return new CostCenters($this->client);
    }

    /**
     * Returns the currencies resource.
     *
     * @return \Warbio\Fortnox\Resources\Currency\Currencies
     */
    public function currencies()
    {
        return new Currencies($this->client);
    }

    /**
     * Returns the customers resource.
     *
     * @return \Warbio\Fortnox\Resources\Customer\Customers
     */
    public function customers()
    {
        return new Customers($this->client);
    }


    /**
     * Returns the eomployees resource.
     *
     * @return \Warbio\Fortnox\Resources\Customer\Employees
     */
    public function employees()
    {
        return new Employees($this->client);
    }


    /**
     * Returns the financial years resource.
     *
     * @return \Warbio\Fortnox\Resources\FinancialYear\FinancialYears
     */
    public function financialYears()
    {
        return new FinancialYears($this->client);
    }

    /**
     * Returns the inbox resource.
     *
     * @return \Warbio\Fortnox\Resources\Inbox\Inboxes
     */
    public function inbox() {
        return new Inbox($this->client);
    }

    /**
     * Returns the invoices resource.
     *
     * @return \Warbio\Fortnox\Resources\Invoice\Invoices
     */
    public function invoices()
    {
        return new Invoices($this->client);
    }

    /**
     * Returns the invoices accruals resource.
     *
     * @return \Warbio\Fortnox\Resources\Invoice\InvoiceAccruals
     */
    public function invoiceAccruals()
    {
        return new InvoiceAccruals($this->client);
    }

    /**
     * Returns the invoices payments resource.
     *
     * @return \Warbio\Fortnox\Resources\Invoice\InvoicePayments
     */
    public function invoicePayments()
    {
        return new InvoicePayments($this->client);
    }

    /**
     * Returns the price lists resource.
     *
     * @return \Warbio\Fortnox\Resources\Price\PriceLists
     */
    public function priceLists()
    {
        return new PriceLists($this->client);
    }

    /**
     * Returns the projects resource.
     *
     * @return \Warbio\Fortnox\Resources\Account\Projects
     */
    public function projects()
    {
        return new Projects($this->client);
    }

    /**
     * Returns the supplier invoices resource.
     *
     * @return \Warbio\Fortnox\Resources\Supplier\SupplierInvoices
     */
    public function supplierInvoices()
    {
        return new SupplierInvoices($this->client);
    }

    /**
     * Returns the suppliers resource.
     *
     * @return \Warbio\Fortnox\Resources\Supplier\Suppliers
     */
    public function suppliers()
    {
        return new Suppliers($this->client);
    }

    /**
     * Returns the supplier invoice file connections resource.
     *
     * @return \Warbio\Fortnox\Resources\Supplier\SupplierInvoiceFileConnections
     */
    public function supplierInvoiceFileConnections()
    {
        return new SupplierInvoiceFileConnections($this->client);
    }

    /**
     * Returns the print templates resource.
     *
     * @return \Warbio\Fortnox\Resources\Template\PrintTemplates
     */
    public function printTemplates()
    {
        return new PrintTemplates($this->client);
    }


    /**
     * Returns the salary transactions resource.
     *
     * @return \Warbio\Fortnox\Resources\Employee\SalaryTransactions
     */
    public function salaryTransactions()
    {
        return new SalaryTransactions($this->client);
    }

    /**
     * Returns the attendance transactions resource.
     *
     * @return \Warbio\Fortnox\Resources\Employee\AttendanceTransactions
     */
    public function attendanceTransactions()
    {
        return new AttendanceTransactions($this->client);
    }

    /**
     * Returns the absence transactions resource.
     *
     * @return \Warbio\Fortnox\Resources\Employee\AbsenceTransactions
     */

    public function absenceTransactions()
    {
        return new AbsenceTransactions($this->client);
    }

    /**
     * Returns the schedule times resource.
     * @return \Warbio\Fortnox\Resources\Employee\ScheduleTimes
     */
    public function scheduleTimes() {
        return new ScheduleTimes($this->client);
    }

    /**
     * Returns the terms of deliveries resource.
     *
     * @return \Warbio\Fortnox\Resources\Terms\TermsOfDeliveries
     */
    public function termsOfDeliveries()
    {
        return new TermsOfDeliveries($this->client);
    }

    /**
     * Returns the terms of payments resource.
     *
     * @return \Warbio\Fortnox\Resources\Terms\TermsOfPayments
     */
    public function termsOfPayments()
    {
        return new TermsOfPayments($this->client);
    }

    /**
     * Returns the units resource.
     *
     * @return \Warbio\Fortnox\Resources\Unit\Units
     */
    public function units()
    {
        return new Units($this->client);
    }

    /**
     * Returns the vouchers resource.
     *
     * @return \Warbio\Fortnox\Resources\Voucher\Vouchers
     */
    public function vouchers()
    {
        return new Vouchers($this->client);
    }

    /**
     * Returns the voucher series resource.
     *
     * @return \Warbio\Fortnox\Resources\Voucher\VoucherSeries
     */
    public function voucherSeries()
    {
        return new VoucherSeries($this->client);
    }
}
