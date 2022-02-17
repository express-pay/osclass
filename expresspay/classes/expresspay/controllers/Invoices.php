<?php

class ExpressPayInvoicesController extends AdminSecBaseModel 
{
    public function doInvoicesList()
    {
        $listInvoices = ExpressPayInvoiceModel::newInstance()->listAll();
        $totalInvoices = count(ExpressPayInvoiceModel::newInstance()->listAll());
        // Экспорт данных для представления.
        View::newInstance()->_exportVariableToView(
            "expresspay_invoices_list",
            $listInvoices
        );
        View::newInstance()->_exportVariableToView(
            "expresspay-invoices-count",
            $totalInvoices
        );
    }
}