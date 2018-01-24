@extends('app')

@section('content')
	<div class="control-list">
    <table class="table data" data-control="rowlink">
        <thead>
            <tr>
                <th class="list-checkbox"><input type="checkbox" id="checkboxAll" /> </th>
                <th class="sort-desc"><a href="/">Title</a></th>
                <th class="active sort-asc"><a href="/">Created</a></th>
                <th class="sort-desc"><a href="/">Price</a></th>
                <th><span>Categories</span></th>
                <th><span>Published</span></th>
                <th><span>Updated</span></th>
                <th class="list-setup"><a href="/" title="List options"></a></th>
            </tr>
        </thead>
        <tbody>
        	@foreach($listaffiliateProducts as  $listaffiliateProduct)
            <tr>
                <td class="list-checkbox nolink"> <input id="checkbox_1" type="checkbox" /> </td>
                <td><a href="{{ url('admin/affiliate-product/update/'.$listaffiliateProduct->id) }}">{{ $listaffiliateProduct->title }}</a></td>
                <td>{{ $listaffiliateProduct->created_at }}</td>
                <td>{{ number_format($listaffiliateProduct->price, 2) }}</td>
                <td>Mobiles</td>
                	@if($listaffiliateProduct->is_published)
                		<td>{{ "Yes" }}</td>
                	@else
                		<td>{{ "No" }}</td>
                	@endif
                <td>{{ $listaffiliateProduct->updated_at }}</td>
                <td>&nbsp;</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="list-footer">
        <div class="list-pagination">
            <div class="control-pagination">
                <span class="page-iteration">1-5 of 20</span>
                <a href="#" class="page-back" title="Previous page"></a><a href="#" class="page-next" title="Next page"></a>
            </div>
        </div>
    </div>
</div>
 @endsection