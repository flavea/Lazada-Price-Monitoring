<center class="uk-margin-large uk-display-block">
    <div uk-spinner id="pageLoader"></div>
</center>
<div class="uk-container uk-margin-large" style="display: none">
	<div uk-grid-match" uk-grid>
		<div class="uk-background-muted uk-padding-large uk-margin-large-bottom uk-width-expand@s">
			<h1 id="productName" class="uk-heading-divider"></h1>
			<h3>Rp <span id="productPrice"></span></h3>
			<p id="productDescription"></p>
			<a id="productLink" class="uk-button uk-button-danger uk-button-large uk-width-expand" href="" target="_blank">Buy This Product</a>
		</div>

		<div id="detail" class="uk-width-2-3@m">
			<div class="sliderTemp" style="display:none">
                <div class="uk-background-muted uk-display-block uk-height-1-1">
                    <a class="uk-inline" href="">
                        <img src="" alt="">
                    </a>
                </div>
			</div>

			<div id="images" class="uk-child-width-1-5@m uk-child-width-1-3@s" uk-grid uk-lightbox="animation: slide">
			</div>

			<div class="uk-margin-large-top">
                <div  uk-grid>
                    <div class="uk-width-2-5@m">
                        <table style="display:none">
                            <tr class="pTemp">
                                <td class="iDate"></td>
                                <td class="iPrice"></td>
                            </tr>
                        </table>

                        <table id="smallList" class="uk-table uk-table-divider">
                            <thead>
                                <tr>
                                    <th>Datetime</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="uk-width-3-5@m">
                        <canvas id="smallChart" height="220px"></canvas>
                    </div>
                </div>

				<center>
                    <a id="productPrice" class="uk-button uk-button-danger uk-button-large uk-margin-top" href="#full-history" uk-toggle>See complete history</a>
                </center>

                <div id="full-history" class="uk-modal-full" uk-modal>
                    <div class="uk-modal-dialog uk-height-1-1 uk-overflow-auto">
                        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
                        <div class="uk-grid-collapse"" uk-grid>
                            
                            <h2 class="uk-text-center uk-margin-large-top uk-width-3-3">Full History</h2>
                            <div class="uk-padding-large uk-width-expand@s">
					            <canvas id="bigChart" class="uk-height-1-1"></canvas>
                            </div>
                            <div class="uk-padding-large uk-width-3-3@s  uk-width-1-3@m">
                                <table id="bigList" class="uk-table uk-table-divider">
                                    <thead>
                                        <tr>
                                            <th>Datetime</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>

	</div>

	<h1 class="uk-heading-divider">Comments</h1>

	<div id="comment-box" class="uk-background-muted uk-padding-small uk-margin-large-bottom main-box">
		<div class="uk-margin">
			<input class="uk-input" type="text" placeholder="Your alias" id="alias">
		</div>

		<div class="uk-margin">
			<textarea class="uk-textarea" rows="5" placeholder="Your comment" id="comment"></textarea>
		</div>

		<div class="uk-margin uk-text-right">
			<input type="submit" class="uk-button uk-button-danger btnComment" value="Submit comment"></input>
		</div>
	</div>

    <li class="iComment" style="display: none">
        <article class="uk-comment">
            <header class="uk-comment-header uk-grid-medium uk-flex-middle uk-position-relative"" uk-grid>
                <div class="uk-width-expand">
                    <h4 class="uk-comment-title uk-margin-remove"></h4>
                </div>
                <div class="uk-position-top-right uk-position-small">
                    <a uk-icon="chevron-up" class="uk-icon-button upvote"></a>
                    <span class="upvote-number uk-margin-right uk-margin-small-left"></span>
                    <a uk-icon="chevron-down" class="uk-icon-button downvote"></a>
                    <span class="downvote-number uk-margin-small-left"></span>
                </div>
            </header>
            <div class="uk-comment-body uk-margin-small-bottom">
            </div>
            
            <button class="uk-button uk-button-default reply">Reply</button>
            <hr>
        </article>
        <ul>
        </ul>
    </li>

    <ul class="uk-comment-list" id="comments">
    </ul>
</div>