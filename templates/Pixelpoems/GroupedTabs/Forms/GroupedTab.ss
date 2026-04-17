<% loop $Tabs %>
<div $getAttributesHTML("class") class="tab-pane $extraClass">
	<% loop $Fields %>
		$FieldHolder
	<% end_loop %>
</div>
<% end_loop %>
