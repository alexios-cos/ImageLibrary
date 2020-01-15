<?php /** @var app\Views\HomeView $this */ ?>

<div id="dialog-message" class="interactive"></div>
<div id="dialog-image" class="interactive"></div>
<div id="background"></div>

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
            <?php $filters = $this->getFilters() ?>
            <?php if (isset($filters['widthRange'])): ?>
                <?php $minResolution = "{$filters['widthRange']['minWidth']['value']}x{$filters['heightRange']['minHeight']['value']}" ?>
                <?php $maxResolution = "{$filters['widthRange']['maxWidth']['value']}x{$filters['heightRange']['maxHeight']['value']}" ?>
            <?php endif; ?>
            <?php if (isset($filters['size'])): ?>
                <?php $size = $filters['size']['value'] ?>
            <?php endif; ?>
            <?php if (isset($filters['views'])): ?>
                <?php $views = $filters['views']['value'] ?>
            <?php endif; ?>
            <div class="filter text">
                <span>resolution:</span>
            </div>
            <div class="filter">
                <label for="min-resolution-filter"></label>
                <input type="text" id="min-resolution-filter" class="filter-input range" value="<?php echo $minResolution ?? '' ?>" placeholder="min (e.g 90x70)" data-name="minResolution">
            </div>
            <span>-</span>
            <div class="filter">
                <label for="max-resolution-filter"></label>
                <input type="text" id="max-resolution-filter" class="filter-input range" value="<?php echo $maxResolution ?? '' ?>" placeholder="max" data-name="maxResolution">
            </div>
            <div class="filter">
                <label for="size-filter"></label>
                <input type="text" id="size-filter" class="filter-input operator"
                       value="<?php echo $size ?? '' ?>"
                       placeholder="size (kb)" data-name="size">
                <select class="filter-operator interactive">
                    <?php foreach ($this->getOperatorSet() as $operator): ?>
                        <option <?php if ($this->getCurrentSizeOperator() === $operator): ?>selected<?php endif; ?> value="<?php echo $operator ?>"><?php echo $operator ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter">
                <label for="view-filter"></label>
                <input type="text" id="view-filter" class="filter-input operator"
                       value="<?php echo $views ?? '' ?>"
                       placeholder="views amount" data-name="views">
                <select class="filter-operator interactive">
                    <?php foreach ($this->getOperatorSet() as $operator): ?>
                        <option <?php if ($this->getCurrentViewsOperator() === $operator): ?>selected<?php endif; ?> value="<?php echo $operator ?>"><?php echo $operator ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter">
                <input type="button" id="apply-filter" class="interactive submit" value="Apply filters">
            </div>
            <div class="filter">
                <input type="button" id="clear-filter" class="interactive submit" value="x">
            </div>
        </div>
        <div id="list">
            <?php if ($images = $this->getImageCollection()): ?>
                <?php $counter = 0 ?>
                <?php foreach ($images as $image): ?>
                    <?php if ($counter === 0): ?>
                        <div class="preview-row">
                    <?php endif; ?>
                    <div class="preview-box">
                        <div class="preview-image interactive" data-image="<?php echo $image['image_path'] ?>" data-id="<?php echo $image['image_id'] ?>"><img src="<?php echo $image['preview_path'] ?>" alt="<?php echo $image['name'] ?>" title="<?php echo $image['name'] ?>"></div>
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
                <?php foreach ($this->getPerPageSet() as $perPage): ?>
                    <option <?php if ($this->getCurrentPerPage() === $perPage): ?>selected<?php endif; ?> value="<?php echo $perPage ?>"><?php echo $perPage ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="pages">
            <?php if ($pages = $this->getTotalPages()): ?>
                <?php $currentPage = $this->getCurrentPage() ?>
                <?php if ($pages > 9): ?>
                    <div class="page interactive">
                        <span><</span>
                    </div>
                <?php endif; ?>
                <?php foreach ($this->getVisiblePages() as $page): ?>
                    <div class="page interactive <?php if ($page === $currentPage): ?>current<?php endif;?>" data-page="<?php echo $page ?>">
                        <span><?php echo $page ?></span>
                    </div>
                <?php endforeach; ?>
                <?php if ($pages > 9): ?>
                    <div class="page interactive">
                        <span>></span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
