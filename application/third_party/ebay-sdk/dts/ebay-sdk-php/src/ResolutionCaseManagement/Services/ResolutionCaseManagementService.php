<?php
/**
 * DO NOT EDIT THIS FILE!
 *
 * This file was automatically generated from external sources.
 *
 * Any manual change here will be lost the next time the SDK
 * is updated. You've been warned!
 */

namespace DTS\eBaySDK\ResolutionCaseManagement\Services;

class ResolutionCaseManagementService extends \DTS\eBaySDK\ResolutionCaseManagement\Services\ResolutionCaseManagementBaseService
{
    const API_VERSION = '1.3.0';

    /**
     * @param array $config Configuration option values.
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\GetVersionRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\GetVersionResponse
     */
    public function getVersion(\DTS\eBaySDK\ResolutionCaseManagement\Types\GetVersionRequest $request)
    {
        return $this->getVersionAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\GetVersionRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getVersionAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\GetVersionRequest $request)
    {
        return $this->callOperationAsync(
            'getVersion',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\GetVersionResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\GetUserCasesRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\GetUserCasesResponse
     */
    public function getUserCases(\DTS\eBaySDK\ResolutionCaseManagement\Types\GetUserCasesRequest $request)
    {
        return $this->getUserCasesAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\GetUserCasesRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getUserCasesAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\GetUserCasesRequest $request)
    {
        return $this->callOperationAsync(
            'getUserCases',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\GetUserCasesResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\GetEBPCaseDetailRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\GetEBPCaseDetailResponse
     */
    public function getEBPCaseDetail(\DTS\eBaySDK\ResolutionCaseManagement\Types\GetEBPCaseDetailRequest $request)
    {
        return $this->getEBPCaseDetailAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\GetEBPCaseDetailRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getEBPCaseDetailAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\GetEBPCaseDetailRequest $request)
    {
        return $this->callOperationAsync(
            'getEBPCaseDetail',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\GetEBPCaseDetailResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\GetActivityOptionsRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\GetActivityOptionsResponse
     */
    public function getActivityOptions(\DTS\eBaySDK\ResolutionCaseManagement\Types\GetActivityOptionsRequest $request)
    {
        return $this->getActivityOptionsAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\GetActivityOptionsRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getActivityOptionsAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\GetActivityOptionsRequest $request)
    {
        return $this->callOperationAsync(
            'getActivityOptions',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\GetActivityOptionsResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\IssueFullRefundRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\IssueFullRefundResponse
     */
    public function issueFullRefund(\DTS\eBaySDK\ResolutionCaseManagement\Types\IssueFullRefundRequest $request)
    {
        return $this->issueFullRefundAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\IssueFullRefundRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function issueFullRefundAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\IssueFullRefundRequest $request)
    {
        return $this->callOperationAsync(
            'issueFullRefund',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\IssueFullRefundResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideTrackingInfoRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideTrackingInfoResponse
     */
    public function provideTrackingInfo(\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideTrackingInfoRequest $request)
    {
        return $this->provideTrackingInfoAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideTrackingInfoRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function provideTrackingInfoAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideTrackingInfoRequest $request)
    {
        return $this->callOperationAsync(
            'provideTrackingInfo',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideTrackingInfoResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\OfferOtherSolutionRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\OfferOtherSolutionResponse
     */
    public function offerOtherSolution(\DTS\eBaySDK\ResolutionCaseManagement\Types\OfferOtherSolutionRequest $request)
    {
        return $this->offerOtherSolutionAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\OfferOtherSolutionRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function offerOtherSolutionAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\OfferOtherSolutionRequest $request)
    {
        return $this->callOperationAsync(
            'offerOtherSolution',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\OfferOtherSolutionResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\EscalateToCustomerSupportRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\EscalateToCustomerSupportResponse
     */
    public function escalateToCustomerSupport(\DTS\eBaySDK\ResolutionCaseManagement\Types\EscalateToCustomerSupportRequest $request)
    {
        return $this->escalateToCustomerSupportAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\EscalateToCustomerSupportRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function escalateToCustomerSupportAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\EscalateToCustomerSupportRequest $request)
    {
        return $this->callOperationAsync(
            'escalateToCustomerSupport',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\EscalateToCustomerSupportResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\AppealToCustomerSupportRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\AppealToCustomerSupportResponse
     */
    public function appealToCustomerSupport(\DTS\eBaySDK\ResolutionCaseManagement\Types\AppealToCustomerSupportRequest $request)
    {
        return $this->appealToCustomerSupportAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\AppealToCustomerSupportRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function appealToCustomerSupportAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\AppealToCustomerSupportRequest $request)
    {
        return $this->callOperationAsync(
            'appealToCustomerSupport',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\AppealToCustomerSupportResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\OfferPartialRefundRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\OfferPartialRefundResponse
     */
    public function offerPartialRefund(\DTS\eBaySDK\ResolutionCaseManagement\Types\OfferPartialRefundRequest $request)
    {
        return $this->offerPartialRefundAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\OfferPartialRefundRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function offerPartialRefundAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\OfferPartialRefundRequest $request)
    {
        return $this->callOperationAsync(
            'offerPartialRefund',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\OfferPartialRefundResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\IssuePartialRefundRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\IssuePartialRefundResponse
     */
    public function issuePartialRefund(\DTS\eBaySDK\ResolutionCaseManagement\Types\IssuePartialRefundRequest $request)
    {
        return $this->issuePartialRefundAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\IssuePartialRefundRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function issuePartialRefundAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\IssuePartialRefundRequest $request)
    {
        return $this->callOperationAsync(
            'issuePartialRefund',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\IssuePartialRefundResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideShippingInfoRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideShippingInfoResponse
     */
    public function provideShippingInfo(\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideShippingInfoRequest $request)
    {
        return $this->provideShippingInfoAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideShippingInfoRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function provideShippingInfoAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideShippingInfoRequest $request)
    {
        return $this->callOperationAsync(
            'provideShippingInfo',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideShippingInfoResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideReturnInfoRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideReturnInfoResponse
     */
    public function provideReturnInfo(\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideReturnInfoRequest $request)
    {
        return $this->provideReturnInfoAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideReturnInfoRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function provideReturnInfoAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideReturnInfoRequest $request)
    {
        return $this->callOperationAsync(
            'provideReturnInfo',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideReturnInfoResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideRefundInfoRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideRefundInfoResponse
     */
    public function provideRefundInfo(\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideRefundInfoRequest $request)
    {
        return $this->provideRefundInfoAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideRefundInfoRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function provideRefundInfoAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideRefundInfoRequest $request)
    {
        return $this->callOperationAsync(
            'provideRefundInfo',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\ProvideRefundInfoResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\UploadDocumentsRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\UploadDocumentsResponse
     */
    public function uploadDocuments(\DTS\eBaySDK\ResolutionCaseManagement\Types\UploadDocumentsRequest $request)
    {
        return $this->uploadDocumentsAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\UploadDocumentsRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function uploadDocumentsAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\UploadDocumentsRequest $request)
    {
        return $this->callOperationAsync(
            'uploadDocuments',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\UploadDocumentsResponse'
        );
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\OfferRefundUponReturnRequest $request
     * @return \DTS\eBaySDK\ResolutionCaseManagement\Types\OfferRefundUponReturnResponse
     */
    public function offerRefundUponReturn(\DTS\eBaySDK\ResolutionCaseManagement\Types\OfferRefundUponReturnRequest $request)
    {
        return $this->offerRefundUponReturnAsync($request)->wait();
    }

    /**
     * @param \DTS\eBaySDK\ResolutionCaseManagement\Types\OfferRefundUponReturnRequest $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function offerRefundUponReturnAsync(\DTS\eBaySDK\ResolutionCaseManagement\Types\OfferRefundUponReturnRequest $request)
    {
        return $this->callOperationAsync(
            'offerRefundUponReturn',
            $request,
            '\DTS\eBaySDK\ResolutionCaseManagement\Types\OfferRefundUponReturnResponse'
        );
    }
}
