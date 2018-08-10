<?php

declare(strict_types=1);

namespace ApiBundle\Form\Handler;

use ApiBundle\Form\FormOptionsRetriever;
use ApiBundle\Model\ApiModel;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class AbstractFormHandler.
 */
abstract class AbstractFormHandler implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected const CONTEXT_GROUP = 'Default';

    private const RETURN_URL_PARAM = 'return_url';

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var FormOptionsRetriever
     */
    protected $formOptions;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var TwigEngine
     */
    protected $templating;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var mixed
     */
    protected $model;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * Http method.
     *
     * @var string
     */
    protected $method;

    /**
     * @var ViewHandler
     */
    protected $viewHandler;

    /**
     * Injects form handler.
     *
     * @param ViewHandler $viewHandler
     */
    public function setViewHandler(ViewHandler $viewHandler): void
    {
        $this->viewHandler = $viewHandler;
    }

    /**
     * On class construct.
     *
     * @param FormFactoryInterface $formFactory
     * @param FormOptionsRetriever $formOptions
     * @param Router               $router
     * @param TwigEngine           $templating
     * @param EntityManager        $em
     * @param Session              $session
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        FormOptionsRetriever $formOptions,
        Router $router,
        TwigEngine $templating,
        EntityManager $em,
        Session $session
    ) {
        $this->formFactory = $formFactory;
        $this->formOptions = $formOptions;
        $this->router      = $router;
        $this->templating  = $templating;
        $this->em          = $em;
        $this->session     = $session;
    }

    /**
     * Gets new model instance.
     *
     * @return mixed
     */
    abstract public function getNewModelInstance();

    /**
     * Gets new type instance.
     *
     * @return string
     */
    abstract public function getNewTypeInstance(): string;

    /**
     * Gets Model.
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets Model.
     *
     * @param mixed $model
     *
     * @return AbstractFormHandler
     */
    public function setModel($model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Gets Method.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Sets Method.
     *
     * @param string $method
     *
     * @return $this
     */
    public function setMethod($method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Gets current request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * Set request stack service.
     *
     * @param RequestStack $requestStack
     *
     * @return $this
     */
    public function setRequestStack(RequestStack $requestStack): self
    {
        $this->requestStack = $requestStack;

        return $this;
    }

    /**
     * Gets container.
     *
     * @return ContainerInterface
     */
    protected function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * Handles form submission.
     *
     * @return RedirectResponse|Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function handle()
    {
        $this->buildForm();

        return $this->getRequest()->query->has('validate')
            ? $this->validate()
            : $this->handleForm();
    }

    /**
     * Builds form
     * Defines form type and model.
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function buildForm(): void
    {
        $this->model = $this->model ?: $this->getNewModelInstance();
        $this->form  = $this->formFactory->create($this->getNewTypeInstance(), $this->model, $this->getFormOptions());
    }

    /**
     * On form submission failed.
     *
     * @return Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException
     */
    public function onFailed(): Response
    {
        return $this->renderForm();
    }

    /**
     * Trigger on success submission.
     *
     * @return Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onSuccess(): Response
    {
        $isNew = false;
        if (!$this->model->getId()) {
            $isNew = true;
        }
        $this->em->persist($this->model);
        $this->em->flush($this->model);
        $context = new Context();
        $context->addGroup(static::CONTEXT_GROUP);

        return $this->viewHandler->handle(
            View::create($this->model)->setStatusCode(
                $isNew
                    ? Response::HTTP_CREATED
                    : Response::HTTP_NO_CONTENT
            )->setFormat('json')->setContext($context));
    }

    /**
     * Validates the form and gets JSON response.
     *
     * @return Response
     *
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     */
    public function validate(): Response
    {
        $this->form->submit($this->getRequest());

        return $this->validationJSONResponse();
    }

    /**
     * Gets form.
     *
     * @return Form
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function getForm(): Form
    {
        $this->buildForm();

        return $this->form;
    }

    /**
     * Renders form model.
     *
     * @return ApiModel
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function getApiModel(): ApiModel
    {
        $form = $this->renderFields();

        return (new ApiModel())->setFields($form['children']);
    }

    /**
     * Renders form fields.
     *
     * @return array
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function renderFields(): array
    {
        $this->buildForm();

        return $this->formOptions->getDefinitions($this->form);
    }

    /**
     * Renders the form.
     *
     * @return Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException
     */
    public function renderForm(): Response
    {
        return $this->renderFormOrErrorResponse($this->getRequest(), $this->form);
    }

    /**
     * Renders form view or missing data view.
     *
     * @param Request       $request
     * @param FormInterface $form
     *
     * @return Response|null
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException
     */
    public function renderFormOrErrorResponse(Request $request, FormInterface $form): ?Response
    {
        if ($request->isMethod('GET')) {
            return null;
        }

        $view = $form->getErrors()->count()
            ? $this->getFormView($form)
            : $this->getPostMissingDataView($form);

        return $this->viewHandler->handle($view ?: $this->getFormView($form));
    }

    /**
     * Gets form options for create form
     * Can be used for example when csrf should be disabled.
     *
     * @return array
     */
    protected function getFormOptions(): array
    {
        return [
            'csrf_protection' => false,
            'method'          => $this->getMethod(),
        ];
    }

    /**
     * Submits form.
     */
    protected function submitForm(): void
    {
        $this->form->handleRequest($this->getRequest());
    }

    /**
     * Handles the form.
     *
     * @return Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException
     */
    protected function handleForm(): Response
    {
        try {
            $this->submitForm();
            if ($this->form->isSubmitted()) {
                return $this->form->isValid() ? $this->onSuccess() : $this->onFailed();
            }
        } catch (\Exception $exception) {
            $this->form->addError(new FormError($exception->getMessage()));

            return $this->onFailed();
        }

        return $this->renderForm();
    }

    /**
     * Gets security context.
     *
     * @return AuthorizationCheckerInterface
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     */
    protected function getAuthorizationChecker(): AuthorizationCheckerInterface
    {
        return $this->container->get('security.authorization_checker');
    }

    /**
     * Gets form view.
     *
     * @param FormInterface $form
     *
     * @return View
     */
    protected function getFormView(FormInterface $form): View
    {
        $statusCode = $form->getErrors()->findByCodes(409) ? 409 : null;

        return View::create($form, $statusCode);
    }

    /**
     * If form is not submitted - gets View with error data.
     *
     * @param FormInterface $form
     *
     * @return View|null
     */
    protected function getPostMissingDataView(FormInterface $form): ?View
    {
        return $form->isSubmitted() ? null : View::create(
            array(
                'code'    => 406,
                'message' => 'Missing data parameter',
                'errors'  => array(sprintf('Missing request data key: %s', $form->getName())),
            )
        )->setStatusCode(406);
    }

    /**
     * Adds flash message.
     *
     * @param string $key
     * @param string $value
     */
    protected function addFlash($key, $value): void
    {
        $this->session->getFlashBag()->add($key, $value);
    }

    /**
     * Renders validation errors.
     *
     * @return Response
     */
    protected function validationJSONResponse(): Response
    {
        $errors = $this->collectErrors();

        $response = [
            'errors' => $errors,
            'length' => count($errors),
        ];

        return new JsonResponse($response);
    }

    /**
     * Collect errors from the form children.
     *
     * @return array
     */
    protected function collectErrors(): array
    {
        $errors = [];

        $this->collectErrorsChildren($this->form, $errors, $this->form->getName());

        foreach ($this->form->getErrors() as $error) {
            $errors[$this->form->getName()][] = $error->getMessage();
        }

        return $errors;
    }

    /**
     * Collect errors from the form children.
     *
     * @param FormInterface $form
     * @param array         &$errors
     * @param string        $prefix
     *f
     *
     * @return array
     */
    protected function collectErrorsChildren(FormInterface $form, array &$errors = [], $prefix = ''): array
    {
        foreach ($form->all() as $key => $child) {
            /* @var Form $child */
            $errorName = $prefix.'_'.$key;
            if (count($child->getErrors())) {
                /* @var FormErrorIterator $child->getErrors()*/
                foreach ($child->getErrors() as $error) {
                    @$errors[$errorName][] = $error->getMessage();
                }
            }
            $this->collectErrorsChildren($child, $errors, $errorName);
        }

        return $errors;
    }

    /**
     * Gets return url request parameter.
     *
     * @return string|null
     */
    protected function getReturnUrl(): ?string
    {
        return $this->getRequest()->get(self::RETURN_URL_PARAM);
    }
}
