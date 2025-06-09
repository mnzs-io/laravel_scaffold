// types/education.ts

export interface Address {
    street: string;
    number?: string;
    complement?: string;
    neighborhood: string;
    city: string;
    state: string;
    postal_code: string;
    country: string;
}

export interface Organization {
    id: string;
    name: string;
    email: string;
    slug: string;
    color: string | null;
    logo_url: string | null;
    active: boolean;
    address?: Address | null;
}

export interface Course {
    id: string;
    name: string;
    slug: string;
    color: string;
    active: boolean;
    organization_id: string;
    created_at?: string;
    updated_at?: string;
}

export interface Subject {
    id: string;
    name: string;
    slug: string;
    color: string;
    course_id: string;
    active: boolean;
    created_at?: string;
    updated_at?: string;
}

export interface Topic {
    id: string;
    name: string;
    slug: string;
    subject_id: string;
    active: boolean;
    created_at?: string;
    updated_at?: string;
}

export interface Card {
    id: string;
    title: string;
    topic_id: string;
    content: string;
    active: boolean;
    created_at?: string;
    updated_at?: string;
}

export interface Question {
    id: string;
    card_id: string;
    enunciation: string;
    active: boolean;
    created_at?: string;
    updated_at?: string;
    alternatives?: Alternative[];
    answer?: Answer;
}

export interface Alternative {
    id: string;
    question_id: string;
    label: string;
    is_correct: boolean;
    created_at?: string;
    updated_at?: string;
}

export interface Answer {
    id: string;
    user_id: string;
    question_id: string;
    alternative_id: string;
    created_at?: string;
    updated_at?: string;
}

export interface SubjectPreview {
    id: string;
    name: string;
    slug: string;
}

export interface TeacherWithSubjects {
    id: string;
    name: string;
    email: string;
    avatar: string;
    subjects: SubjectPreview[];
}
