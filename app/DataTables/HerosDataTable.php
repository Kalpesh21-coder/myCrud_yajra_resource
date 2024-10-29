<?php

namespace App\DataTables;

use App\Models\Hero;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class HerosDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'heros.action')->
           editColumn('action',function($hero){
            return ' <div >
            <a style = "margin-right: 10px;  text-decoration: none; color: orange; border: 2px solid; border-radius: 10px; padding: 3px; " href="'.route('hero.show',$hero->id).'">Show</a>

            <a onclick="deleteData(\''.route('hero.destroy',$hero->id).'\')" style = "margin-right: 10px;  text-decoration: none; color: red; border: 2px solid; border-radius: 10px; padding: 3px; " href="javascript:void(0)">Delete</a>


             <a style = "margin-right:10px;  text-decoration: none; color: green; border: 2px solid; border-radius: 10px; padding: 3px;  "  href="'.route('hero.edit',$hero->id).'">Edit</a>
            </div>';
           })
            ->setRowId('id');


    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Hero $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('heros-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('price'),
            Column::make('image'),


            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(200)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Heros_' . date('YmdHis');
    }
}
