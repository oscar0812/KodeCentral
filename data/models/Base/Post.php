<?php

namespace Base;

use \Comment as ChildComment;
use \CommentQuery as ChildCommentQuery;
use \Library as ChildLibrary;
use \LibraryQuery as ChildLibraryQuery;
use \Post as ChildPost;
use \PostQuery as ChildPostQuery;
use \User as ChildUser;
use \UserFavorite as ChildUserFavorite;
use \UserFavoriteQuery as ChildUserFavoriteQuery;
use \UserQuery as ChildUserQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\CommentTableMap;
use Map\PostTableMap;
use Map\UserFavoriteTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class that represents a row from the 'post' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Post implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PostTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the title field.
     *
     * @var        string
     */
    protected $title;

    /**
     * The value for the hyperlink field.
     *
     * @var        string
     */
    protected $hyperlink;

    /**
     * The value for the text field.
     *
     * @var        string
     */
    protected $text;

    /**
     * The value for the posted_date field.
     *
     * @var        DateTime
     */
    protected $posted_date;

    /**
     * The value for the posted_by_user_id field.
     *
     * @var        int
     */
    protected $posted_by_user_id;

    /**
     * The value for the library_id field.
     *
     * @var        int
     */
    protected $library_id;

    /**
     * The value for the library_index field.
     *
     * @var        int
     */
    protected $library_index;

    /**
     * @var        ChildUser
     */
    protected $aPostedByUser;

    /**
     * @var        ChildLibrary
     */
    protected $aLibrary;

    /**
     * @var        ObjectCollection|ChildComment[] Collection to store aggregation of ChildComment objects.
     */
    protected $collComments;
    protected $collCommentsPartial;

    /**
     * @var        ObjectCollection|ChildUserFavorite[] Collection to store aggregation of ChildUserFavorite objects.
     */
    protected $collUserFavorites;
    protected $collUserFavoritesPartial;

    /**
     * @var        ObjectCollection|ChildUser[] Cross Collection to store aggregation of ChildUser objects.
     */
    protected $collFavoriteUsers;

    /**
     * @var bool
     */
    protected $collFavoriteUsersPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // validate behavior

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * ConstraintViolationList object
     *
     * @see     http://api.symfony.com/2.0/Symfony/Component/Validator/ConstraintViolationList.html
     * @var     ConstraintViolationList
     */
    protected $validationFailures;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUser[]
     */
    protected $favoriteUsersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComment[]
     */
    protected $commentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserFavorite[]
     */
    protected $userFavoritesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Post object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Post</code> instance.  If
     * <code>obj</code> is an instance of <code>Post</code>, delegates to
     * <code>equals(Post)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Post The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [hyperlink] column value.
     *
     * @return string
     */
    public function getHyperlink()
    {
        return $this->hyperlink;
    }

    /**
     * Get the [text] column value.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get the [optionally formatted] temporal [posted_date] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getPostedDate($format = NULL)
    {
        if ($format === null) {
            return $this->posted_date;
        } else {
            return $this->posted_date instanceof \DateTimeInterface ? $this->posted_date->format($format) : null;
        }
    }

    /**
     * Get the [posted_by_user_id] column value.
     *
     * @return int
     */
    public function getPostedByUserId()
    {
        return $this->posted_by_user_id;
    }

    /**
     * Get the [library_id] column value.
     *
     * @return int
     */
    public function getLibraryId()
    {
        return $this->library_id;
    }

    /**
     * Get the [library_index] column value.
     *
     * @return int
     */
    public function getLibraryIndex()
    {
        return $this->library_index;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PostTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[PostTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [hyperlink] column.
     *
     * @param string $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setHyperlink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hyperlink !== $v) {
            $this->hyperlink = $v;
            $this->modifiedColumns[PostTableMap::COL_HYPERLINK] = true;
        }

        return $this;
    } // setHyperlink()

    /**
     * Set the value of [text] column.
     *
     * @param string $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setText($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->text !== $v) {
            $this->text = $v;
            $this->modifiedColumns[PostTableMap::COL_TEXT] = true;
        }

        return $this;
    } // setText()

    /**
     * Sets the value of [posted_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setPostedDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->posted_date !== null || $dt !== null) {
            if ($this->posted_date === null || $dt === null || $dt->format("Y-m-d") !== $this->posted_date->format("Y-m-d")) {
                $this->posted_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PostTableMap::COL_POSTED_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setPostedDate()

    /**
     * Set the value of [posted_by_user_id] column.
     *
     * @param int $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setPostedByUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->posted_by_user_id !== $v) {
            $this->posted_by_user_id = $v;
            $this->modifiedColumns[PostTableMap::COL_POSTED_BY_USER_ID] = true;
        }

        if ($this->aPostedByUser !== null && $this->aPostedByUser->getId() !== $v) {
            $this->aPostedByUser = null;
        }

        return $this;
    } // setPostedByUserId()

    /**
     * Set the value of [library_id] column.
     *
     * @param int $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setLibraryId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->library_id !== $v) {
            $this->library_id = $v;
            $this->modifiedColumns[PostTableMap::COL_LIBRARY_ID] = true;
        }

        if ($this->aLibrary !== null && $this->aLibrary->getId() !== $v) {
            $this->aLibrary = null;
        }

        return $this;
    } // setLibraryId()

    /**
     * Set the value of [library_index] column.
     *
     * @param int $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setLibraryIndex($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->library_index !== $v) {
            $this->library_index = $v;
            $this->modifiedColumns[PostTableMap::COL_LIBRARY_INDEX] = true;
        }

        return $this;
    } // setLibraryIndex()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PostTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PostTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PostTableMap::translateFieldName('Hyperlink', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hyperlink = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PostTableMap::translateFieldName('Text', TableMap::TYPE_PHPNAME, $indexType)];
            $this->text = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PostTableMap::translateFieldName('PostedDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->posted_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PostTableMap::translateFieldName('PostedByUserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->posted_by_user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PostTableMap::translateFieldName('LibraryId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->library_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PostTableMap::translateFieldName('LibraryIndex', TableMap::TYPE_PHPNAME, $indexType)];
            $this->library_index = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = PostTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Post'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aPostedByUser !== null && $this->posted_by_user_id !== $this->aPostedByUser->getId()) {
            $this->aPostedByUser = null;
        }
        if ($this->aLibrary !== null && $this->library_id !== $this->aLibrary->getId()) {
            $this->aLibrary = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PostTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPostQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPostedByUser = null;
            $this->aLibrary = null;
            $this->collComments = null;

            $this->collUserFavorites = null;

            $this->collFavoriteUsers = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Post::setDeleted()
     * @see Post::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPostQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PostTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aPostedByUser !== null) {
                if ($this->aPostedByUser->isModified() || $this->aPostedByUser->isNew()) {
                    $affectedRows += $this->aPostedByUser->save($con);
                }
                $this->setPostedByUser($this->aPostedByUser);
            }

            if ($this->aLibrary !== null) {
                if ($this->aLibrary->isModified() || $this->aLibrary->isNew()) {
                    $affectedRows += $this->aLibrary->save($con);
                }
                $this->setLibrary($this->aLibrary);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->favoriteUsersScheduledForDeletion !== null) {
                if (!$this->favoriteUsersScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->favoriteUsersScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \UserFavoriteQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->favoriteUsersScheduledForDeletion = null;
                }

            }

            if ($this->collFavoriteUsers) {
                foreach ($this->collFavoriteUsers as $favoriteUser) {
                    if (!$favoriteUser->isDeleted() && ($favoriteUser->isNew() || $favoriteUser->isModified())) {
                        $favoriteUser->save($con);
                    }
                }
            }


            if ($this->commentsScheduledForDeletion !== null) {
                if (!$this->commentsScheduledForDeletion->isEmpty()) {
                    \CommentQuery::create()
                        ->filterByPrimaryKeys($this->commentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->commentsScheduledForDeletion = null;
                }
            }

            if ($this->collComments !== null) {
                foreach ($this->collComments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userFavoritesScheduledForDeletion !== null) {
                if (!$this->userFavoritesScheduledForDeletion->isEmpty()) {
                    \UserFavoriteQuery::create()
                        ->filterByPrimaryKeys($this->userFavoritesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userFavoritesScheduledForDeletion = null;
                }
            }

            if ($this->collUserFavorites !== null) {
                foreach ($this->collUserFavorites as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[PostTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PostTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PostTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PostTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(PostTableMap::COL_HYPERLINK)) {
            $modifiedColumns[':p' . $index++]  = 'hyperlink';
        }
        if ($this->isColumnModified(PostTableMap::COL_TEXT)) {
            $modifiedColumns[':p' . $index++]  = 'text';
        }
        if ($this->isColumnModified(PostTableMap::COL_POSTED_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'posted_date';
        }
        if ($this->isColumnModified(PostTableMap::COL_POSTED_BY_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'posted_by_user_id';
        }
        if ($this->isColumnModified(PostTableMap::COL_LIBRARY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'library_id';
        }
        if ($this->isColumnModified(PostTableMap::COL_LIBRARY_INDEX)) {
            $modifiedColumns[':p' . $index++]  = 'library_index';
        }

        $sql = sprintf(
            'INSERT INTO post (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'hyperlink':
                        $stmt->bindValue($identifier, $this->hyperlink, PDO::PARAM_STR);
                        break;
                    case 'text':
                        $stmt->bindValue($identifier, $this->text, PDO::PARAM_STR);
                        break;
                    case 'posted_date':
                        $stmt->bindValue($identifier, $this->posted_date ? $this->posted_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'posted_by_user_id':
                        $stmt->bindValue($identifier, $this->posted_by_user_id, PDO::PARAM_INT);
                        break;
                    case 'library_id':
                        $stmt->bindValue($identifier, $this->library_id, PDO::PARAM_INT);
                        break;
                    case 'library_index':
                        $stmt->bindValue($identifier, $this->library_index, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PostTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getTitle();
                break;
            case 2:
                return $this->getHyperlink();
                break;
            case 3:
                return $this->getText();
                break;
            case 4:
                return $this->getPostedDate();
                break;
            case 5:
                return $this->getPostedByUserId();
                break;
            case 6:
                return $this->getLibraryId();
                break;
            case 7:
                return $this->getLibraryIndex();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Post'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Post'][$this->hashCode()] = true;
        $keys = PostTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getHyperlink(),
            $keys[3] => $this->getText(),
            $keys[4] => $this->getPostedDate(),
            $keys[5] => $this->getPostedByUserId(),
            $keys[6] => $this->getLibraryId(),
            $keys[7] => $this->getLibraryIndex(),
        );
        if ($result[$keys[4]] instanceof \DateTimeInterface) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPostedByUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user';
                        break;
                    default:
                        $key = 'PostedByUser';
                }

                $result[$key] = $this->aPostedByUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aLibrary) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'library';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'library';
                        break;
                    default:
                        $key = 'Library';
                }

                $result[$key] = $this->aLibrary->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collComments) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'comments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'comments';
                        break;
                    default:
                        $key = 'Comments';
                }

                $result[$key] = $this->collComments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserFavorites) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userFavorites';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_favorites';
                        break;
                    default:
                        $key = 'UserFavorites';
                }

                $result[$key] = $this->collUserFavorites->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Post
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PostTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Post
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $this->setHyperlink($value);
                break;
            case 3:
                $this->setText($value);
                break;
            case 4:
                $this->setPostedDate($value);
                break;
            case 5:
                $this->setPostedByUserId($value);
                break;
            case 6:
                $this->setLibraryId($value);
                break;
            case 7:
                $this->setLibraryIndex($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PostTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTitle($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setHyperlink($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setText($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPostedDate($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPostedByUserId($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setLibraryId($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setLibraryIndex($arr[$keys[7]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Post The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PostTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PostTableMap::COL_ID)) {
            $criteria->add(PostTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PostTableMap::COL_TITLE)) {
            $criteria->add(PostTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(PostTableMap::COL_HYPERLINK)) {
            $criteria->add(PostTableMap::COL_HYPERLINK, $this->hyperlink);
        }
        if ($this->isColumnModified(PostTableMap::COL_TEXT)) {
            $criteria->add(PostTableMap::COL_TEXT, $this->text);
        }
        if ($this->isColumnModified(PostTableMap::COL_POSTED_DATE)) {
            $criteria->add(PostTableMap::COL_POSTED_DATE, $this->posted_date);
        }
        if ($this->isColumnModified(PostTableMap::COL_POSTED_BY_USER_ID)) {
            $criteria->add(PostTableMap::COL_POSTED_BY_USER_ID, $this->posted_by_user_id);
        }
        if ($this->isColumnModified(PostTableMap::COL_LIBRARY_ID)) {
            $criteria->add(PostTableMap::COL_LIBRARY_ID, $this->library_id);
        }
        if ($this->isColumnModified(PostTableMap::COL_LIBRARY_INDEX)) {
            $criteria->add(PostTableMap::COL_LIBRARY_INDEX, $this->library_index);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildPostQuery::create();
        $criteria->add(PostTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Post (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setHyperlink($this->getHyperlink());
        $copyObj->setText($this->getText());
        $copyObj->setPostedDate($this->getPostedDate());
        $copyObj->setPostedByUserId($this->getPostedByUserId());
        $copyObj->setLibraryId($this->getLibraryId());
        $copyObj->setLibraryIndex($this->getLibraryIndex());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getComments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserFavorites() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserFavorite($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Post Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Post The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPostedByUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setPostedByUserId(NULL);
        } else {
            $this->setPostedByUserId($v->getId());
        }

        $this->aPostedByUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addPost($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getPostedByUser(ConnectionInterface $con = null)
    {
        if ($this->aPostedByUser === null && ($this->posted_by_user_id != 0)) {
            $this->aPostedByUser = ChildUserQuery::create()->findPk($this->posted_by_user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPostedByUser->addPosts($this);
             */
        }

        return $this->aPostedByUser;
    }

    /**
     * Declares an association between this object and a ChildLibrary object.
     *
     * @param  ChildLibrary $v
     * @return $this|\Post The current object (for fluent API support)
     * @throws PropelException
     */
    public function setLibrary(ChildLibrary $v = null)
    {
        if ($v === null) {
            $this->setLibraryId(NULL);
        } else {
            $this->setLibraryId($v->getId());
        }

        $this->aLibrary = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildLibrary object, it will not be re-added.
        if ($v !== null) {
            $v->addPost($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildLibrary object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildLibrary The associated ChildLibrary object.
     * @throws PropelException
     */
    public function getLibrary(ConnectionInterface $con = null)
    {
        if ($this->aLibrary === null && ($this->library_id != 0)) {
            $this->aLibrary = ChildLibraryQuery::create()->findPk($this->library_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aLibrary->addPosts($this);
             */
        }

        return $this->aLibrary;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Comment' == $relationName) {
            $this->initComments();
            return;
        }
        if ('UserFavorite' == $relationName) {
            $this->initUserFavorites();
            return;
        }
    }

    /**
     * Clears out the collComments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addComments()
     */
    public function clearComments()
    {
        $this->collComments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collComments collection loaded partially.
     */
    public function resetPartialComments($v = true)
    {
        $this->collCommentsPartial = $v;
    }

    /**
     * Initializes the collComments collection.
     *
     * By default this just sets the collComments collection to an empty array (like clearcollComments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initComments($overrideExisting = true)
    {
        if (null !== $this->collComments && !$overrideExisting) {
            return;
        }

        $collectionClassName = CommentTableMap::getTableMap()->getCollectionClassName();

        $this->collComments = new $collectionClassName;
        $this->collComments->setModel('\Comment');
    }

    /**
     * Gets an array of ChildComment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPost is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     * @throws PropelException
     */
    public function getComments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsPartial && !$this->isNew();
        if (null === $this->collComments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collComments) {
                // return empty collection
                $this->initComments();
            } else {
                $collComments = ChildCommentQuery::create(null, $criteria)
                    ->filterByPost($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentsPartial && count($collComments)) {
                        $this->initComments(false);

                        foreach ($collComments as $obj) {
                            if (false == $this->collComments->contains($obj)) {
                                $this->collComments->append($obj);
                            }
                        }

                        $this->collCommentsPartial = true;
                    }

                    return $collComments;
                }

                if ($partial && $this->collComments) {
                    foreach ($this->collComments as $obj) {
                        if ($obj->isNew()) {
                            $collComments[] = $obj;
                        }
                    }
                }

                $this->collComments = $collComments;
                $this->collCommentsPartial = false;
            }
        }

        return $this->collComments;
    }

    /**
     * Sets a collection of ChildComment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $comments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function setComments(Collection $comments, ConnectionInterface $con = null)
    {
        /** @var ChildComment[] $commentsToDelete */
        $commentsToDelete = $this->getComments(new Criteria(), $con)->diff($comments);


        $this->commentsScheduledForDeletion = $commentsToDelete;

        foreach ($commentsToDelete as $commentRemoved) {
            $commentRemoved->setPost(null);
        }

        $this->collComments = null;
        foreach ($comments as $comment) {
            $this->addComment($comment);
        }

        $this->collComments = $comments;
        $this->collCommentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Comment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Comment objects.
     * @throws PropelException
     */
    public function countComments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsPartial && !$this->isNew();
        if (null === $this->collComments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collComments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getComments());
            }

            $query = ChildCommentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPost($this)
                ->count($con);
        }

        return count($this->collComments);
    }

    /**
     * Method called to associate a ChildComment object to this object
     * through the ChildComment foreign key attribute.
     *
     * @param  ChildComment $l ChildComment
     * @return $this|\Post The current object (for fluent API support)
     */
    public function addComment(ChildComment $l)
    {
        if ($this->collComments === null) {
            $this->initComments();
            $this->collCommentsPartial = true;
        }

        if (!$this->collComments->contains($l)) {
            $this->doAddComment($l);

            if ($this->commentsScheduledForDeletion and $this->commentsScheduledForDeletion->contains($l)) {
                $this->commentsScheduledForDeletion->remove($this->commentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildComment $comment The ChildComment object to add.
     */
    protected function doAddComment(ChildComment $comment)
    {
        $this->collComments[]= $comment;
        $comment->setPost($this);
    }

    /**
     * @param  ChildComment $comment The ChildComment object to remove.
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function removeComment(ChildComment $comment)
    {
        if ($this->getComments()->contains($comment)) {
            $pos = $this->collComments->search($comment);
            $this->collComments->remove($pos);
            if (null === $this->commentsScheduledForDeletion) {
                $this->commentsScheduledForDeletion = clone $this->collComments;
                $this->commentsScheduledForDeletion->clear();
            }
            $this->commentsScheduledForDeletion[]= clone $comment;
            $comment->setPost(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Post is new, it will return
     * an empty collection; or if this Post has previously
     * been saved, it will retrieve related Comments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Post.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getComments($query, $con);
    }

    /**
     * Clears out the collUserFavorites collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserFavorites()
     */
    public function clearUserFavorites()
    {
        $this->collUserFavorites = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserFavorites collection loaded partially.
     */
    public function resetPartialUserFavorites($v = true)
    {
        $this->collUserFavoritesPartial = $v;
    }

    /**
     * Initializes the collUserFavorites collection.
     *
     * By default this just sets the collUserFavorites collection to an empty array (like clearcollUserFavorites());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserFavorites($overrideExisting = true)
    {
        if (null !== $this->collUserFavorites && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserFavoriteTableMap::getTableMap()->getCollectionClassName();

        $this->collUserFavorites = new $collectionClassName;
        $this->collUserFavorites->setModel('\UserFavorite');
    }

    /**
     * Gets an array of ChildUserFavorite objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPost is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserFavorite[] List of ChildUserFavorite objects
     * @throws PropelException
     */
    public function getUserFavorites(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserFavoritesPartial && !$this->isNew();
        if (null === $this->collUserFavorites || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserFavorites) {
                // return empty collection
                $this->initUserFavorites();
            } else {
                $collUserFavorites = ChildUserFavoriteQuery::create(null, $criteria)
                    ->filterByFavoritePost($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserFavoritesPartial && count($collUserFavorites)) {
                        $this->initUserFavorites(false);

                        foreach ($collUserFavorites as $obj) {
                            if (false == $this->collUserFavorites->contains($obj)) {
                                $this->collUserFavorites->append($obj);
                            }
                        }

                        $this->collUserFavoritesPartial = true;
                    }

                    return $collUserFavorites;
                }

                if ($partial && $this->collUserFavorites) {
                    foreach ($this->collUserFavorites as $obj) {
                        if ($obj->isNew()) {
                            $collUserFavorites[] = $obj;
                        }
                    }
                }

                $this->collUserFavorites = $collUserFavorites;
                $this->collUserFavoritesPartial = false;
            }
        }

        return $this->collUserFavorites;
    }

    /**
     * Sets a collection of ChildUserFavorite objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userFavorites A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function setUserFavorites(Collection $userFavorites, ConnectionInterface $con = null)
    {
        /** @var ChildUserFavorite[] $userFavoritesToDelete */
        $userFavoritesToDelete = $this->getUserFavorites(new Criteria(), $con)->diff($userFavorites);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->userFavoritesScheduledForDeletion = clone $userFavoritesToDelete;

        foreach ($userFavoritesToDelete as $userFavoriteRemoved) {
            $userFavoriteRemoved->setFavoritePost(null);
        }

        $this->collUserFavorites = null;
        foreach ($userFavorites as $userFavorite) {
            $this->addUserFavorite($userFavorite);
        }

        $this->collUserFavorites = $userFavorites;
        $this->collUserFavoritesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserFavorite objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserFavorite objects.
     * @throws PropelException
     */
    public function countUserFavorites(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserFavoritesPartial && !$this->isNew();
        if (null === $this->collUserFavorites || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserFavorites) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserFavorites());
            }

            $query = ChildUserFavoriteQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFavoritePost($this)
                ->count($con);
        }

        return count($this->collUserFavorites);
    }

    /**
     * Method called to associate a ChildUserFavorite object to this object
     * through the ChildUserFavorite foreign key attribute.
     *
     * @param  ChildUserFavorite $l ChildUserFavorite
     * @return $this|\Post The current object (for fluent API support)
     */
    public function addUserFavorite(ChildUserFavorite $l)
    {
        if ($this->collUserFavorites === null) {
            $this->initUserFavorites();
            $this->collUserFavoritesPartial = true;
        }

        if (!$this->collUserFavorites->contains($l)) {
            $this->doAddUserFavorite($l);

            if ($this->userFavoritesScheduledForDeletion and $this->userFavoritesScheduledForDeletion->contains($l)) {
                $this->userFavoritesScheduledForDeletion->remove($this->userFavoritesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUserFavorite $userFavorite The ChildUserFavorite object to add.
     */
    protected function doAddUserFavorite(ChildUserFavorite $userFavorite)
    {
        $this->collUserFavorites[]= $userFavorite;
        $userFavorite->setFavoritePost($this);
    }

    /**
     * @param  ChildUserFavorite $userFavorite The ChildUserFavorite object to remove.
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function removeUserFavorite(ChildUserFavorite $userFavorite)
    {
        if ($this->getUserFavorites()->contains($userFavorite)) {
            $pos = $this->collUserFavorites->search($userFavorite);
            $this->collUserFavorites->remove($pos);
            if (null === $this->userFavoritesScheduledForDeletion) {
                $this->userFavoritesScheduledForDeletion = clone $this->collUserFavorites;
                $this->userFavoritesScheduledForDeletion->clear();
            }
            $this->userFavoritesScheduledForDeletion[]= clone $userFavorite;
            $userFavorite->setFavoritePost(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Post is new, it will return
     * an empty collection; or if this Post has previously
     * been saved, it will retrieve related UserFavorites from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Post.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserFavorite[] List of ChildUserFavorite objects
     */
    public function getUserFavoritesJoinFavoriteUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserFavoriteQuery::create(null, $criteria);
        $query->joinWith('FavoriteUser', $joinBehavior);

        return $this->getUserFavorites($query, $con);
    }

    /**
     * Clears out the collFavoriteUsers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFavoriteUsers()
     */
    public function clearFavoriteUsers()
    {
        $this->collFavoriteUsers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collFavoriteUsers crossRef collection.
     *
     * By default this just sets the collFavoriteUsers collection to an empty collection (like clearFavoriteUsers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initFavoriteUsers()
    {
        $collectionClassName = UserFavoriteTableMap::getTableMap()->getCollectionClassName();

        $this->collFavoriteUsers = new $collectionClassName;
        $this->collFavoriteUsersPartial = true;
        $this->collFavoriteUsers->setModel('\User');
    }

    /**
     * Checks if the collFavoriteUsers collection is loaded.
     *
     * @return bool
     */
    public function isFavoriteUsersLoaded()
    {
        return null !== $this->collFavoriteUsers;
    }

    /**
     * Gets a collection of ChildUser objects related by a many-to-many relationship
     * to the current object by way of the user_favorite cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPost is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildUser[] List of ChildUser objects
     */
    public function getFavoriteUsers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFavoriteUsersPartial && !$this->isNew();
        if (null === $this->collFavoriteUsers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collFavoriteUsers) {
                    $this->initFavoriteUsers();
                }
            } else {

                $query = ChildUserQuery::create(null, $criteria)
                    ->filterByFavoritePost($this);
                $collFavoriteUsers = $query->find($con);
                if (null !== $criteria) {
                    return $collFavoriteUsers;
                }

                if ($partial && $this->collFavoriteUsers) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collFavoriteUsers as $obj) {
                        if (!$collFavoriteUsers->contains($obj)) {
                            $collFavoriteUsers[] = $obj;
                        }
                    }
                }

                $this->collFavoriteUsers = $collFavoriteUsers;
                $this->collFavoriteUsersPartial = false;
            }
        }

        return $this->collFavoriteUsers;
    }

    /**
     * Sets a collection of User objects related by a many-to-many relationship
     * to the current object by way of the user_favorite cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $favoriteUsers A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function setFavoriteUsers(Collection $favoriteUsers, ConnectionInterface $con = null)
    {
        $this->clearFavoriteUsers();
        $currentFavoriteUsers = $this->getFavoriteUsers();

        $favoriteUsersScheduledForDeletion = $currentFavoriteUsers->diff($favoriteUsers);

        foreach ($favoriteUsersScheduledForDeletion as $toDelete) {
            $this->removeFavoriteUser($toDelete);
        }

        foreach ($favoriteUsers as $favoriteUser) {
            if (!$currentFavoriteUsers->contains($favoriteUser)) {
                $this->doAddFavoriteUser($favoriteUser);
            }
        }

        $this->collFavoriteUsersPartial = false;
        $this->collFavoriteUsers = $favoriteUsers;

        return $this;
    }

    /**
     * Gets the number of User objects related by a many-to-many relationship
     * to the current object by way of the user_favorite cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related User objects
     */
    public function countFavoriteUsers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFavoriteUsersPartial && !$this->isNew();
        if (null === $this->collFavoriteUsers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFavoriteUsers) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getFavoriteUsers());
                }

                $query = ChildUserQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByFavoritePost($this)
                    ->count($con);
            }
        } else {
            return count($this->collFavoriteUsers);
        }
    }

    /**
     * Associate a ChildUser to this object
     * through the user_favorite cross reference table.
     *
     * @param ChildUser $favoriteUser
     * @return ChildPost The current object (for fluent API support)
     */
    public function addFavoriteUser(ChildUser $favoriteUser)
    {
        if ($this->collFavoriteUsers === null) {
            $this->initFavoriteUsers();
        }

        if (!$this->getFavoriteUsers()->contains($favoriteUser)) {
            // only add it if the **same** object is not already associated
            $this->collFavoriteUsers->push($favoriteUser);
            $this->doAddFavoriteUser($favoriteUser);
        }

        return $this;
    }

    /**
     *
     * @param ChildUser $favoriteUser
     */
    protected function doAddFavoriteUser(ChildUser $favoriteUser)
    {
        $userFavorite = new ChildUserFavorite();

        $userFavorite->setFavoriteUser($favoriteUser);

        $userFavorite->setFavoritePost($this);

        $this->addUserFavorite($userFavorite);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$favoriteUser->isFavoritePostsLoaded()) {
            $favoriteUser->initFavoritePosts();
            $favoriteUser->getFavoritePosts()->push($this);
        } elseif (!$favoriteUser->getFavoritePosts()->contains($this)) {
            $favoriteUser->getFavoritePosts()->push($this);
        }

    }

    /**
     * Remove favoriteUser of this object
     * through the user_favorite cross reference table.
     *
     * @param ChildUser $favoriteUser
     * @return ChildPost The current object (for fluent API support)
     */
    public function removeFavoriteUser(ChildUser $favoriteUser)
    {
        if ($this->getFavoriteUsers()->contains($favoriteUser)) {
            $userFavorite = new ChildUserFavorite();
            $userFavorite->setFavoriteUser($favoriteUser);
            if ($favoriteUser->isFavoritePostsLoaded()) {
                //remove the back reference if available
                $favoriteUser->getFavoritePosts()->removeObject($this);
            }

            $userFavorite->setFavoritePost($this);
            $this->removeUserFavorite(clone $userFavorite);
            $userFavorite->clear();

            $this->collFavoriteUsers->remove($this->collFavoriteUsers->search($favoriteUser));

            if (null === $this->favoriteUsersScheduledForDeletion) {
                $this->favoriteUsersScheduledForDeletion = clone $this->collFavoriteUsers;
                $this->favoriteUsersScheduledForDeletion->clear();
            }

            $this->favoriteUsersScheduledForDeletion->push($favoriteUser);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPostedByUser) {
            $this->aPostedByUser->removePost($this);
        }
        if (null !== $this->aLibrary) {
            $this->aLibrary->removePost($this);
        }
        $this->id = null;
        $this->title = null;
        $this->hyperlink = null;
        $this->text = null;
        $this->posted_date = null;
        $this->posted_by_user_id = null;
        $this->library_id = null;
        $this->library_index = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collComments) {
                foreach ($this->collComments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserFavorites) {
                foreach ($this->collUserFavorites as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFavoriteUsers) {
                foreach ($this->collFavoriteUsers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collComments = null;
        $this->collUserFavorites = null;
        $this->collFavoriteUsers = null;
        $this->aPostedByUser = null;
        $this->aLibrary = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PostTableMap::DEFAULT_STRING_FORMAT);
    }

    // validate behavior

    /**
     * Configure validators constraints. The Validator object uses this method
     * to perform object validation.
     *
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('title', new NotNull());
        $metadata->addPropertyConstraint('hyperlink', new NotNull());
        $metadata->addPropertyConstraint('text', new NotNull());
        $metadata->addPropertyConstraint('posted_date', new NotNull());
    }

    /**
     * Validates the object and all objects related to this table.
     *
     * @see        getValidationFailures()
     * @param      ValidatorInterface|null $validator A Validator class instance
     * @return     boolean Whether all objects pass validation.
     */
    public function validate(ValidatorInterface $validator = null)
    {
        if (null === $validator) {
            $validator = new RecursiveValidator(
                new ExecutionContextFactory(new IdentityTranslator()),
                new LazyLoadingMetadataFactory(new StaticMethodLoader()),
                new ConstraintValidatorFactory()
            );
        }

        $failureMap = new ConstraintViolationList();

        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aPostedByUser, 'validate')) {
                if (!$this->aPostedByUser->validate($validator)) {
                    $failureMap->addAll($this->aPostedByUser->getValidationFailures());
                }
            }
            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aLibrary, 'validate')) {
                if (!$this->aLibrary->validate($validator)) {
                    $failureMap->addAll($this->aLibrary->getValidationFailures());
                }
            }

            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collComments) {
                foreach ($this->collComments as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collUserFavorites) {
                foreach ($this->collUserFavorites as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }

            $this->alreadyInValidation = false;
        }

        $this->validationFailures = $failureMap;

        return (Boolean) (!(count($this->validationFailures) > 0));

    }

    /**
     * Gets any ConstraintViolation objects that resulted from last call to validate().
     *
     *
     * @return     object ConstraintViolationList
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
