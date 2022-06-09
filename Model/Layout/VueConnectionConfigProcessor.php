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

namespace HawkSearch\EsIndexing\Model\Layout;

use HawkSearch\EsIndexing\Model\Config\ApiSettings;

class VueConnectionConfigProcessor implements LayoutConfigProcessorInterface
{
    /**
     * @var ApiSettings
     */
    private $apiSettings;

    /**
     * ConnectionConfigProcessor constructor.
     * @param ApiSettings $apiSettings
     */
    public function __construct(
        ApiSettings $apiSettings
    ) {
        $this->apiSettings = $apiSettings;
    }

    /**
     * @inheritDoc
     */
    public function process($jsConfig)
    {
        $connectionConfig = [
            'apiUrl' => $this->apiSettings->getSearchApiUrl(),
            'dashboardUrl' => $this->apiSettings->getApiUrl(),
            'clientGuid' => $this->apiSettings->getTrackingKey(),
            'trackEventUrl' => $this->apiSettings->getTrackingUrl(),
        ];
        return array_merge_recursive($jsConfig ?? [], $connectionConfig);
    }
}
