import { connect } from 'react-redux';
import IdeaPageBase from '../IdeaPageBase';
import { DELETE_IDEA_MODAL } from '../../constants/modalTypes';
import { showModal } from '../../redux/actions/modal';
import { deleteCurrentIdea, goBackFromCurrentIdea } from '../../redux/thunk/currentIdea';
import { selectAuthUser } from '../../redux/selectors/auth';

function mapStateToProps(state) {
    const currentUser = selectAuthUser(state);
    const metadata = { authorName: currentUser.name, createdAt: new Date().toLocaleDateString() };
    return {
        isAuthor: true,
        metadata,
        isEditing: true,
    };
}

function mapDispatchToProps(dispatch) {
    // TODO: replace with actual action creators
    return {
        onBackClicked: () => dispatch(goBackFromCurrentIdea()),
        onPublishClicked: () => alert('Publier'),
        onDeleteClicked: () =>
            dispatch(
                showModal(DELETE_IDEA_MODAL, {
                    onConfirmDelete: () => dispatch(deleteCurrentIdea()),
                })
            ),
        onSaveClicked: () => alert('Enregistrer'),
    };
}

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(IdeaPageBase);