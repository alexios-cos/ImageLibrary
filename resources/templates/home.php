<div id="content">
    <div id="upload-container">
        <div id="upload">
            <form id="upload-form" action="/upload-image" method="post" enctype="multipart/form-data">
                <div class="upload-element">
                    <span class="header">Chose image to upload:</span>
                </div>
                <div class="upload-element">
                    <input type="file" name="uploadImage" id="upload-image" class="interactive submit">
                </div>
                <div class="upload-element">
                    <input type="submit" id="upload-button" value="Upload" name="submit" class="interactive submit">
                </div>
            </form>
        </div>
    </div>
    <div id="list-container">
        <div id="filters">
            <div class="filter">
                <label for="resolution-filter"></label>
                <input type="text" id="resolution-filter" placeholder="resolution (e.g. 1650x1080)">
            </div>
            <div class="filter">
                <label for="size-filter"></label>
                <input type="text" id="size-filter" placeholder="size (kb)">
            </div>
            <div class="filter">
                <label for="view-filter"></label>
                <input type="text" id="view-filter" placeholder="views amount">
            </div>
            <div class="filter">
                <input type="button" id="apply-filter" class="interactive submit" value="Apply filters">
            </div>
        </div>
        <div id="list">
            <?php
            /** @var app\Views\HomeView $this */
            if ($images = $this->getImageCollection()):
            ?>
                <?php $counter = 0 ?>
                <?php foreach ($images as $image): ?>
                    <?php if ($counter === 0): ?>
                        <div class="preview-row">
                    <?php endif; ?>
                    <div class="preview-box">
                        <div class="preview-image interactive"><img src="<?php echo $image['preview_path'] ?>" alt="<?php echo $image['name'] ?>" title="<?php echo $image['name'] ?>"></div>
                    </div>
                    <?php $counter++ ?>
                    <?php if ($counter === 7): ?>
                        </div>
                        <?php $counter = 0 ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div id="pages-container">
        <div id="per-pager">
            <span>Previews per page:</span>
            <label for="per-page-select"></label>
            <select id="per-page-select" class="interactive">
                <option>20</option>
                <option>50</option>
                <option>100</option>
                <option>200</option>
            </select>
        </div>
        <div id="pages">
            <?php if ($pages = $this->getImagePages()): ?>
                <?php $limit = $pages <= 8 ? $pages : 8 ?>
                <?php if ($pages > 8): ?>
                    <div class="page interactive">
                        <span><</span>
                    </div>
                <?php endif; ?>
                <?php for ($page = 1; $page <= $limit; $page++): ?>
                    <div class="page interactive">
                        <span><?php echo $page ?></span>
                    </div>
                <?php endfor; ?>
                <?php if ($pages > 8): ?>
                    <div class="page interactive">
                        <span>></span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
