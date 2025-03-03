<?php
/**
 * Copyright (c) 2021 Hawksearch (www.hawksearch.com) - All Rights Reserved
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */
declare(strict_types=1);

namespace HawkSearch\EsIndexing\Model\Product\ProductType;

use Magento\Bundle\Model\Product\Price;
use Magento\Catalog\Api\Data\ProductInterface;

class Bundle extends CompositeType
{
    /**
     * @var string
     */
    protected $keySelectionsCollection = '_cache_instance_selections_collection_hawksearch';

    /**
     * @inheritDoc
     */
    public function getChildProducts(ProductInterface $product): array
    {
        if (!$product->hasData($this->keySelectionsCollection)) {
            $selectionsCollection = $product->getTypeInstance()->getSelectionsCollection(
                $product->getTypeInstance()->getOptionsIds($product),
                $product
            );
            $product->setData($this->keySelectionsCollection, $selectionsCollection);
        }

        return $product->getData($this->keySelectionsCollection)->getItems();
    }

    /**
     * @inheritDoc
     */
    protected function getMinMaxPrice(ProductInterface $product)
    {
        /** @var Price $priceModel */
        $priceModel = $product->getPriceModel();
        [$min, $max] = $priceModel->getTotalPrices($product, null, true, true);

        return [(float)$min, (float)$max];
    }

}
