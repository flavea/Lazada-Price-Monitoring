<div class="uk-container uk-container-small uk-background-muted uk-padding-large uk-padding-remove-top">
    <table style="display: none">
        <tr class="iTemp">
            <td class="iName"></td>
            <td class="uk-text-center">
                <a class="iMonitor uk-button-primary uk-button" target="_blank">Monitor</a>
                <a class="iLazada uk-button-secondary uk-button" target="_blank">Go To Lazada</a>
            </td>
        </tr>
    </table>
    <center class="uk-margin-large uk-display-block">
        <h3 class="uk-heading-line">Registered Products Lists</h3>
        <div uk-spinner id="pageLoader"></div>
        <span id="notFound" style="display: none">There is no products yet. Go to the main page to add URL.</span>
    </center>
    <table id="products" style="display: none">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>