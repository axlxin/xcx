<form accept-charset="UTF-8" action="{submit_link}" method="GET" style="text-align:center;font-family:Verdana">
	<input name="route" type="hidden" value="module/orderreviews/sendReview" style="font-family:inherit">
	<input name="reviewmail_id" type="hidden" value="{reviewmail_id}" style="font-family:inherit">
	<input name="order_id" type="hidden" value="{order_id}" style="font-family:inherit">
    <input name="author" type="hidden" value="{first_name} {last_name}" style="font-family:inherit">
    <input name="fname" type="hidden" value="{first_name}" style="font-family:inherit">
    <input name="lname" type="hidden" value="{last_name}" style="font-family:inherit">
    <input name="email" type="hidden" value="{email}" style="font-family:inherit">
    <input name="product_ids" type="hidden" value="{product_id}" style="font-family:inherit">
    <input name="customer_id" type="hidden" value="{customer_id}" style="font-family:inherit">
    <input name="name" type="hidden" value="{customer_name}" style="font-family:inherit">
    <table width="100%">
        <tbody>
            <tr>
                <td width="5%" style="font-family:Verdana"></td>
                <td width="90%" style="font-family:Verdana">
                    <table cellspacing="0" cellpadding="0" border="0" style="width:100%">
                        <tbody>
                            <tr>
                                <td width="100%" height="25%" align="left" style="font-family:Verdana;font-size:inherit;padding:15px 0;letter-spacing:0">
                                    {text_review}
                                </td>
                            </tr>
                            <tr>
                            	<td>
									{product_info}
                            	</td>
                            </tr>
                            <tr>
                                <td style="font-family:Verdana;text-align:right">
                                    <input type="submit" style="font-family:inherit;border:1px solid #C57824;padding:6px 13px;text-transform:uppercase;text-decoration:none;background-color:#DF9020;font-size:13px;color:#ffffff" value="✓ {text_submit}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="5%" style="font-family:Verdana"></td>
            </tr>
        </tbody>
    </table>
</form>